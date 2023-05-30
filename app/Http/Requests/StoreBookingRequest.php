<?php

namespace App\Http\Requests;

use Illuminate\Support\Facades\Gate;
use App\Rules\ApartmentAvailableRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreBookingRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Gate::allows('bookings-manage');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            // 'apartment_id' => ['required', 'exists:apartments,id'],
            // 'start_date' => ['required', 'date'],
            // 'end_date' => ['required', 'date'],
            // 'guests_adults' => ['integer'],
            // 'guests_children' => ['integer'],

            'apartment_id' => [
                'required',
                'exists:apartments,id',
                new ApartmentAvailableRule()
            ],
        ];
    }
}
