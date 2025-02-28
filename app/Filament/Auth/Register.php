<?php

namespace App\Filament\Auth;
use App\Models\User;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Pages\Auth\Register as AuthRegister;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class Register extends AuthRegister
{
    protected function getForms(): array
    {
        return [
            'form' => $this->form(
                $this->makeForm()
                    ->schema([
                        $this->getNameFormComponent(),
                        $this->getEmailFormComponent(),
                        $this->getPasswordFormComponent(),
                        $this->getPasswordConfirmationFormComponent(),
                        TextInput::make('phone')
                            ->tel()
                            ->required()
                            ->label('Phone Number')
                            ->placeholder('Enter your phone number'),
                        FileUpload::make('image')
                            ->label('Profile Picture')
                            ->columnSpanFull()
                            ->required()
                            ->image()
                            ->placeholder('Upload your profile picture'),
                        FileUpload::make('scanijazah')
                            ->label('Scan Ijazah')
                            ->columnSpanFull()
                            ->required()
                            ->image()
                            ->placeholder('Upload your last Ijazah'),
                    ])
                    ->statePath('data'),
            )
        ];
    }

    protected function submit(): void
    {
        $data = $this->form->getState();

        $user = User::Create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'phone' => $data['phone'],
            'image' => $data['image'] ?? null,
            'scanijazazah' => $data['scanijazazah'] ?? null,
        ]);

        Auth::login($user);
    }
}
