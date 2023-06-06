<?php

namespace App\Http\Controllers\Owner;

use App\Models\Property;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

/**
 * @group Owner
 * @subgroup Property photo management
 */
class PropertyPhotoController extends Controller
{

     /**
     * Add a photo to a property
     *
     * [Adds a photo to a property and returns the filename, thumbnail and position of the photo]
     *
     * @authenticated
     *
     * @response {"filename": "http://localhost:8000/storage/properties/1/photos/1/IMG_20190601_123456.jpg", "thumbnail": "http://localhost:8000/storage/properties/1/photos/1/conversions/thumbnail.jpg", "position": 1}
     * @response 422 {"message":"The photo must be an image.","errors":{"photo":["The photo must be an image."]}}
     */
    public function store(Property $property, Request $request)
    {
       
        // Validation: file should be an image with a 5 MB size max
        $request->validate([
            'photo' => ['image', 'max:5000']
        ]);

//    Security check: property should belong to the logged-in user, so no one would upload the file to someone else's property
        if ($property->owner_id != auth()->id()) {
            abort(403);
        }

        // Upload the file and assign it to the collection with Media Library
        // for images go form-data in Postman

        $photo = $property->addMediaFromRequest('photo')->toMediaCollection('photos');

        $position = Media::query()
        ->where('model_type', 'App\Models\Property')
        ->where('model_id', $property->id)
        ->max('position') + 1;
        $photo->position = $position;
        $photo->save();
        
        return [
            'filename' => $photo->getUrl(),
            'thumbnail' => $photo->getUrl('thumbnail'),
            'position' => $photo->position,
        ];
    }

     /**
     * Reorder photos of a property
     *
     * [Reorders photos of a property and returns the new position of the photo]
     *
     * @authenticated
     *
     * @urlParam newPosition integer The new position of the photo. Example: 2
     *
     * @response {"newPosition": 2}
     */

    public function reorder(Property $property, Media $photo, int $newPosition)
    {
        // Security check for the property/photo parameters
        if ($property->owner_id != auth()->id() || $photo->model_id != $property->id) {
            abort(403);
        }
    
        // Building the query for related photos to be reordered

        $query = Media::query()
            ->where('model_type', 'App\Models\Property')
            ->where('model_id', $photo->model_id);

            // Depending on the $newPosition, we increment/decrement their positions
        if ($newPosition < $photo->position) {
            $query
                ->whereBetween('position', [$newPosition, $photo->position-1])
                ->increment('position');
        } else {
            $query
                ->whereBetween('position', [$photo->position+1, $newPosition])
                ->decrement('position');
        }

        // update the current photo position.
        $photo->position = $newPosition;
        $photo->save();
    
        return [
            'newPosition' => $photo->position
        ];
    }
}
