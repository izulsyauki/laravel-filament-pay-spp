<?php

namespace App\Filament\Pages;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class Biodata extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static ?string $navigationLabel = 'Biodata';

    protected static string $view = 'filament.pages.biodata';

    public $user;

    public ?array $data = [];

    public function mount(): void
    {
        $this->user = Auth::user();

        $this->form->fill([
            'name' => $this->user->name,
            'email' => $this->user->email,
            'phone' => $this->user->phone,
            'image' => $this->user->image,
            'scanijazah' => $this->user->scanijazah,
        ]);
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make()
                    ->schema([
                        TextInput::make('name')->required(),
                        TextInput::make('email')->required()->email(),
                        TextInput::make('password')->password()
                            ->revealable(filament()->arePasswordsRevealable())->nullable(),
                        TextInput::make('phone')->required(),
                        FileUpload::make('image')->image()->columnSpanFull(),
                        FileUpload::make('scanijazah')->image()->columnSpanFull(),
                    ]),
            ]);
    }

    public function edit(): void
    {
        $validateData = $this->form->getState();

        $this->user->name = $validateData['name'];
        $this->user->email = $validateData['email'];
        $this->user->phone = $validateData['phone'];

        if (!empty($validateData['password'])) {
            $this->user->password = Hash::make($validateData['password']);
        }


        if (isset($validateData['image'])) {
            if ($this->user->image) {
                Storage::delete($this->user->image);
            }
            $this->user->image = $validateData['image'];
        }

        if (isset($validateData['scanijazah'])) {
            if ($this->user->scanijazah) {
                Storage::delete($this->user->scanijazah);
            }
            $this->user->scanijazah = $validateData['scanijazah'];
        }

        $this->user->save();

        Notification::make()
            ->title('Biodata Updated')
            ->success()
            ->body('Your biodata has been updated successfully.')
            ->send();
    }

    public static function getPages(): array
    {
        return [
            'biodata' => Biodata::route('/biodata')
        ];
    }
}
