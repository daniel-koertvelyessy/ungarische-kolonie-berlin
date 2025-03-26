<?php

use App\Livewire\Blog\Post\Form;
use App\Models\Blog\Post;
use App\Models\Membership\Member;
use App\Models\User;
use App\Services\MailingService;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;

// Authentication and Authorization Tests
describe('Blog Post Form - Authorization', function () {
    it('prevents unauthorized users from accessing the form', function () {
        $post = Post::factory()->create();

        // Attempt to access form without authentication
        $response = $this->get('/backend/posts/', [$post])
            ->assertRedirect('/login');
    });

    it('allows authorized users to access the form', function () {
        $user = User::factory()
            ->create();
        $post = Post::factory()
            ->create(['user_id' => $user->id]);

        $this->actingAs($user);

        $component = Livewire::test(Form::class, ['post' => $post]);
        $component->assertOk();
    });
});

// Post Creation Tests
describe('Blog Post Form - Creation', function () {
    beforeEach(function () {
        $this->user = User::factory()
            ->create();
        $this->actingAs($this->user);
        $this->post = Post::factory()
            ->create(['user_id' => $this->user->id,
                'label' => 'Test Post',
                'status' => 'draft',
                'post_type_id' => 1,
            ]);
        $this->member = Member::factory()->create(['user_id' => $this->user->id]);
    });

    it('can create a new blog post with valid data', function () {

        $component = Livewire::test(Form::class, ['post' => $this->post, 'user' => $this->user, 'member' => $this->member])
            ->call('save');

        $component->assertHasNoErrors();

        $this->post->refresh();

        $this->assertDatabaseHas('posts', [
            'label' => 'Test Post',
            'status' => 'draft',
        ]);
    });

    it('validates required fields when creating a post', function () {
        $component = Livewire::test(Form::class)
            ->call('save');

        $component->assertHasErrors([
            'form.label' => 'required',
            'form.title.de' => 'required',
            'form.title.hu' => 'required',
            'form.slug.de' => 'required',
            'form.slug.hu' => 'required',
            //            'form.post_type_id' => 'required',
            //            'form.status' => 'required',
        ]);
    });
});

// Image Upload Tests
describe('Blog Post Form - Image Uploads', function () {
    beforeEach(function () {
        $this->user = User::factory()
            ->create();
        $this->member = Member::factory()
            ->create(['user_id' => $this->user->id]);
        $this->actingAs($this->user);
        Storage::fake('public');
    });

    it('can upload multiple images with captions', function () {
        $images = [
            UploadedFile::fake()
                ->image('post-image-1.jpg', 800, 600),
            UploadedFile::fake()
                ->image('post-image-2.jpg', 1024, 768),
        ];

        $post = Post::factory()
            ->create(['user_id' => $this->user->id]);

        $component = Livewire::test(Form::class)
            ->set('newImages', $images)
//            ->call('updatedNewImages', $images)
            ->set('captionsDe', ['First Image Caption', 'Second Image Caption'])
            ->set('captionsHu', ['Első kép felirata', 'Második kép felirata'])
            ->set('form.title', ['de' => 'Test Titel', 'hu' => 'Test Cím'])
            ->set('form.slug', ['de' => 'Test Slug', 'hu' => 'Test Cím-Slug'])
            ->set('form.label', 'what label')
            ->set('form.post_type_id', $post->post_type_id)
            ->set('form.status', 'draft')
            ->call('save');

        $component->assertHasNoErrors();

        // Assert images were stored
        Storage::disk('public')
            ->assertExists(
                collect($images)
                    ->map(fn ($image) => 'post-images/'.$image->hashName())
                    ->toArray()
            );

        // Assert database records created
        $post = Post::latest()
            ->first();

        $this->assertCount(2, $post->images);
        $this->assertEquals('First Image Caption', $post->images[0]->caption['de']);
        $this->assertEquals('Első kép felirata', $post->images[0]->caption['hu']);
    });

    it('can remove images before saving', function () {
        $images = [
            UploadedFile::fake()
                ->image('post-image-1.jpg'),
            UploadedFile::fake()
                ->image('post-image-2.jpg'),
        ];

        $component = Livewire::test(Form::class)
            ->set('newImages', $images)
//            ->call('updatedNewImages', $images)
            ->call('removeImage', 0)
            ->set('form.title', ['de' => 'Test Titel', 'hu' => 'Test Cím'])
            ->set('form.slug', ['de' => 'Test Slug', 'hu' => 'Test Cím-Slug'])
            ->set('form.label', 'Test Post')
            ->set('form.post_type_id', 2)
            ->set('form.status', 'draft')
            ->call('save');

        $component->assertHasNoErrors();

        // Assert only one image was saved
        $post = Post::latest()
            ->first();
        $this->assertCount(1, $post->images);
    });
});

// Post Publishing Tests
describe('Blog Post Form - Publishing', function () {
    beforeEach(function () {
        $this->user = User::factory()
            ->create();
        $this->actingAs($this->user);
        $this->member = Member::factory()
            ->create(['user_id' => $this->user->id]);
    });

    it('can publish a draft post', function () {
        $post = Post::factory()
            ->create([
                'user_id' => $this->user->id,
                'status' => 'draft',
            ]);

        $component = Livewire::test(Form::class, ['post' => $post])
            ->call('publishPost')
            ->assertJson([
                'components' => [
                    [
                        'effects' => [
                            'dispatches' => [
                                [
                                    'name' => 'toast-show',
                                    'params' => [
                                        'duration' => 5000,
                                        'slots' => [
                                            'text' => 'You have no persmission to access App\\Models\\Blog\\Post. => This action is unauthorized.',
                                            'heading' => 'Forbidden',
                                        ],
                                        'dataset' => [
                                            'variant' => 'danger',
                                        ],
                                    ],
                                ],
                                [
                                    'name' => 'toast-show',
                                    'params' => [
                                        'duration' => '3000',
                                        'slots' => [
                                            'text' => __('post.form.toasts.msg.post_published'),
                                            'heading' => 'Erfolg!',
                                        ],
                                        'dataset' => [
                                            'variant' => 'success',
                                        ],
                                    ],
                                ],
                            ],
                        ],
                    ],
                ],
            ]);

        $post->refresh();
        expect($post->status)
            ->toBe('published')
            ->and($post->published_at)
            ->not()
            ->toBeNull();
    });

    it('can retract a published post', function () {
        $post = Post::factory()
            ->create([
                'user_id' => $this->user->id,
                'status' => 'published',
                'published_at' => now(),
            ]);

        $component = Livewire::test(Form::class, ['post' => $post])
            ->call('resetPublication')
            ->assertJson([
                'components' => [
                    [
                        'effects' => [
                            'dispatches' => [
                                [
                                    'name' => 'toast-show',
                                    'params' => [
                                        'duration' => 5000,
                                        'slots' => [
                                            'text' => 'You have no persmission to access App\\Models\\Blog\\Post. => This action is unauthorized.',
                                            'heading' => 'Forbidden',
                                        ],
                                        'dataset' => [
                                            'variant' => 'danger',
                                        ],
                                    ],
                                ],
                                [
                                    'name' => 'toast-show',
                                    'params' => [
                                        'duration' => '3000',
                                        'slots' => [
                                            'text' => 'Der Artikel wurde zurückgezogen!',
                                            'heading' => 'Erfolg!',
                                        ],
                                        'dataset' => [
                                            'variant' => 'warning',
                                        ],
                                    ],
                                ],
                            ],
                        ],
                    ],
                ],
            ]);

        $post->refresh();
        expect($post->status)
            ->toBe('retracted')
            ->and($post->published_at)
            ->toBeNull();
    });
});

// Notification Tests
describe('Blog Post Form - Notifications', function () {
    beforeEach(function () {
        $this->user = User::factory()
            ->create();
        $this->actingAs($this->user);
        $this->member = Member::factory()
            ->create(['user_id' => $this->user->id]);
    });

    it('can send publication notification', function () {
        $mailingService = Mockery::mock(MailingService::class);
        $mailingService->shouldReceive('sendNotificationsToSubscribers')
            ->once()
            ->with('posts', Mockery::type(Post::class), Mockery::type('string'), 'emails.new_post_notification', []);

        $this->app->instance(MailingService::class, $mailingService);

        $post = Post::factory()
            ->create([
                'user_id' => $this->user->id,
                'status' => 'published',
            ]);

        Livewire::test(Form::class, ['post' => $post])
            ->call('sendPublicationNotification')
            ->assertJson([
                'components' => [
                    [
                        'effects' => [
                            'dispatches' => [
                                [
                                    'name' => 'toast-show',
                                    'params' => [
                                        'duration' => 5000,
                                        'slots' => [
                                            'text' => 'You have no persmission to access App\\Models\\Blog\\Post. => This action is unauthorized.',
                                            'heading' => 'Forbidden',
                                        ],
                                        'dataset' => [
                                            'variant' => 'danger',
                                        ],
                                    ],
                                ],
                                [
                                    'name' => 'toast-show',
                                    'params' => [
                                        'duration' => 8000,
                                        'slots' => [
                                            'text' => __('post.form.toasts.notification_sent_success'),
                                            'heading' => __('post.form.toasts.heading.success'),
                                        ],
                                        'dataset' => [
                                            'variant' => 'success',
                                        ],
                                    ],
                                ],
                            ],
                        ],
                    ],
                ],
            ]);
    });
});
