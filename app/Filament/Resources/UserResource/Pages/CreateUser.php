<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Models\User;
use Filament\Pages\Actions;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use App\Filament\Resources\UserResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Support\Facades\Log;

class CreateUser extends CreateRecord
{
    protected static ?string $model = Role::class;
    protected static string $resource = UserResource::class;


    protected function getSubheading(): string|Htmlable|null
    {
        return 'This form will create an administrator user';
    }


    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['password'] = Hash::make($data['password']);
        $data['role_id'] = Role::where('Administrator')->first()->id;
        // $user->assignRole('Administrator');

        Log::debug($data['role_id']);
 
        return $data;
    }
}
