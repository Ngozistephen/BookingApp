<?php

namespace App\Filament\Resources\GeoobjectResource\Pages;

use App\Filament\Resources\GeoobjectResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListGeoobjects extends ListRecords
{
    protected static string $resource = GeoobjectResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
