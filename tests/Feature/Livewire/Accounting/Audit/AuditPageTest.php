<?php

it('standard user cannot see the audit page', function () {

    $user_issuer = \App\Models\Membership\Member::factory()->create()->user;
    $report = \App\Models\Accounting\AccountReport::factory()->create();

    $audit = \App\Models\Accounting\AccountReportAudit::create([
        'account_report_id' => $report->id,
        $user_issuer = \App\Models\Membership\Member::factory()->create()->user,
        'user_id' => $user_issuer->id,

    ]);

    $not_designated_user = \App\Models\Membership\Member::factory()->create()->user;

    // https://ungarische-kolonie-berlin.test/backend/account-report/audit/1

    $this->actingAs($not_designated_user);

    $response = $this->get(route('account-report.audit', $audit->id));

    $response->assertStatus(302);

});

it('only designated user can see the audit page', function () {

    $user_issuer = \App\Models\Membership\Member::factory()->create()->user;
    $report = \App\Models\Accounting\AccountReport::factory()->create();

    $audit = \App\Models\Accounting\AccountReportAudit::create([
        'account_report_id' => $report->id,
        $user_issuer = \App\Models\Membership\Member::factory()->create()->user,
        'user_id' => $user_issuer->id,
    ]);

    $not_designated_user = \App\Models\Membership\Member::factory()->create()->user;

    // https://ungarische-kolonie-berlin.test/backend/account-report/audit/1

    $this->actingAs($user_issuer);

    $response = $this->get(route('account-report.audit', $audit->id));

    $response->assertStatus(200);

});
