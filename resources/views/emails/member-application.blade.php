<x-mails.header header="Haho"/>

<p>Valaki új tagsági kérelmet nyújtott be. Mivel a rendszer szerint az egyesület vezetőségi tagjaként vagy nyilvántartva, ezért megkaptad ennek az e-mailnek a másolatát.</p>
<p>Kérlek nézd meg :)</p>

<ul style="list-style: none;">
    <li>Vezetéknév: {{ $member->name }}</li>
    <li>Keresztnév: {{ $member->first_name }}</li>
    <li>Születésnap: {{ $member->birth_date->isoFormat('LLL') }}</li>
    <li>E-Mail cím: {{ $member->email }}</li>
    <li>Mobil: {{ $member->mobile }}</li>
    <li>Cím: {{ $member->address }}</li>
    <li>Iranitó: {{ $member->zip }}</li>
    <li>Város: {{ $member->city }}</li>
    <li>Ország: {{ $member->country }}</li>
    <li>Preferált nyelv: {{ $member->locale }}</li>
    <li>Nem: {{ $member->gender }}</li>
    <li>Csökkentett tagsági díjat kérek: {{ $member->is_deducted ? 'igen' : 'nem' }}</li>
    <li>A mentesség oka: {{ $member->deduction_reason }}</li>
</ul>

<x-mails.link-button  href="{{route('dashboard')}}" >Itt szerkesztheti a bejegyzést</x-mails.link-button>

<x-mails.footer/>
