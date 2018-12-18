<div class="row">
    <div class="col-md-6">
        @include('components.forms.basic-input', [
            'key' => 'name',
            'name' => 'Gebruikersnaam',
            'required' => false,
            'value' => $user->name,
            'disabled' => true
        ])

        @include('components.forms.basic-input', [
            'key' => 'email',
            'type' => 'email',
            'name' => 'E-mailadres',
            'required' => false,
            'value' => $user->email,
            'disabled' => true
        ])
    </div>
    <div class="col-md-6">
        @include('components.forms.basic-input', [
            'key' => 'firstname',
            'name' => 'Voornaam',
            'required' => false,
            'value' => $user->firstname,
            'disabled' => true
        ])

        @include('components.forms.basic-input', [
            'key' => 'lastname',
            'name' => 'Achternaam',
            'required' => false,
            'value' => $user->lastname,
            'disabled' => true
        ])

        @include('components.forms.basic-input', [
            'key' => 'birthday',
            'name' => 'Geboortedatum',
            'required' => false,
            'value' => Carbon\Carbon::parse($user->birthday)->format('d-m-Y'),
            'disabled' => true
        ])
    </div>
</div>

<hr>

<div class="row">
    <div class="col-md-6">
        @include('components.forms.basic-input', [
            'key' => 'adress_line_1',
            'name' => 'Adresregel 1',
            'required' => false,
            'value' => $user->adress_line_1,
            'disabled' => true
        ])
    </div>

    <div class="col-md-6">
        <!-- Filler -->
    </div>

    <div class="col-md-6">
        @include('components.forms.basic-input', [
            'key' => 'adress_line_2',
            'name' => 'Adresregel 2',
            'required' => false,
            'value' => $user->adress_line_2,
            'disabled' => true
        ])

        @include('components.forms.basic-input', [
            'key' => 'postalcode',
            'name' => 'Postcode',
            'required' => false,
            'value' => $user->postalcode,
            'disabled' => true
        ])
    </div>

    <div class="col-md-6">
        @include('components.forms.basic-input', [
            'key' => 'city',
            'name' => 'Plaatsnaam',
            'required' => false,
            'value' => $user->city,
            'disabled' => true
        ])

        @include('components.forms.basic-input', [
            'key' => 'country',
            'name' => 'Land',
            'required' => false,
            'value' => $user->country,
            'disabled' => true
        ])
    </div>
</div>
