<?php

namespace App\Filament\Resources\ProductResource\Pages;

use App\Events\NewProductEvent;
use App\Models\User;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;
use App\Filament\Resources\ProductResource;
use App\Notifications\NewProductNotification;
use Illuminate\Support\Facades\Notification as FacadeNoti;

class CreateProduct extends CreateRecord
{
    use CreateRecord\Concerns\Translatable;
    protected static string $resource = ProductResource::class;
    protected function getHeaderActions(): array
    {
        return [
            Actions\LocaleSwitcher::make(),
        ];
    }
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
    protected function getCreatedNotification(): ?Notification
    {
        return Notification::make()
            ->success()
            ->title('Product created')
            ->body('The Product has been created successfully.');
    }
    protected function afterCreate(): void
    {
        $users = User::where('is_admin',false)->get();
        foreach($users as $user){
            FacadeNoti::send($user,new NewProductNotification($this->record));
            event(new NewProductEvent($user));
        }
    }
}
