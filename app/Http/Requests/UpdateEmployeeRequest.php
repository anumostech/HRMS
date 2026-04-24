<?php

namespace App\Http\Requests;
use Carbon\Carbon;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateEmployeeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation()
    {
        $dates = [
            'dob',
            'joining_date',
            'passport_issued_date',
            'passport_expiry_date',
            'visa_issued_date',
            'visa_expiry_date',
            'labor_issued_date',
            'labor_expiry_date',
            'eid_issued_date',
            'eid_expiry_date'
        ];

        foreach ($dates as $field) {
            if ($this->filled($field)) {
                try {
                    $this->merge([
                        $field => Carbon::createFromFormat('d-m-Y', $this->$field)->format('Y-m-d')
                    ]);
                } catch (\Exception $e) {
                    // ignore invalid format
                }
            }
        }

        // Convert special days array
        if ($this->has('special_days_date')) {

            $convertedDates = [];

            foreach ($this->special_days_date as $date) {

                if ($date) {
                    try {
                        $convertedDates[] = Carbon::createFromFormat('d-m-Y', $date)->format('Y-m-d');
                    } catch (\Exception $e) {
                        $convertedDates[] = $date;
                    }
                }
            }

            $this->merge([
                'special_days_date' => $convertedDates
            ]);
        }
    }

    public function rules(): array
    {
        $employee = $this->route('employee');
        
        return [
            'avatar' => 'nullable|string',
            'first_name' => 'required|string|max:255',
            'last_name' => 'nullable|string|max:255',
            'organization_id' => 'nullable|exists:organizations,id',
            'designation_id' => 'nullable|string|max:255',
            'department_id' => 'nullable|string|max:255',
            'company_id' => 'sometimes|required|exists:companies,id',
            'dob' => 'nullable|date',
            'joining_date' => 'nullable|date',
            'gender' => 'nullable|string|max:255',
            'nationality' => 'nullable|string|max:255',
            'marital_status' => 'nullable|string|max:255',
            'special_days_name.*' => 'nullable|string|max:255',
            'special_days_date.*' => 'nullable|date',
            
            // Passport
            'passport_full_name' => 'nullable|string|max:255',
            'passport_number' => 'nullable|string|max:255',
            'passport_issued_from' => 'nullable|string|max:255',
            'passport_issued_date' => 'nullable|date',
            'passport_expiry_date' => 'nullable|date',
            'place_of_birth' => 'nullable|string|max:255',
            'father_name' => 'nullable|string|max:255',
            'mother_name' => 'nullable|string|max:255',
            'address' => 'nullable|string',

             // Documents
            'passport_1st_page' => 'nullable|string',
            'passport_2nd_page' => 'nullable|string',
            'passport_outer_page' => 'nullable|string',
            'passport_id_page' => 'nullable|string',
            'visa_page' => 'nullable|string',
            'labor_card' => 'nullable|string',
            'labor_contract' => 'nullable|string',
            'eid_1st_page' => 'nullable|string',
            'eid_2nd_page' => 'nullable|string',
            'educational_1st_page' => 'nullable|string',
            'educational_2nd_page' => 'nullable|string',
            'home_country_id_proof' => 'nullable|string',

            // Details
            'visa_number' => 'nullable|string|max:255',
            'visa_type' => 'nullable|string|max:255',
            'visa_issued_date' => 'nullable|date',
            'visa_expiry_date' => 'nullable|date',
            'labor_number' => 'nullable|string|max:255',
            'labor_issued_date' => 'nullable|date',
            'labor_expiry_date' => 'nullable|date',
            'eid_number' => 'nullable|string|max:255',
            'eid_issued_date' => 'nullable|date',
            'eid_expiry_date' => 'nullable|date',
            'dependents' => 'nullable|string|max:255',
            'company_mobile_number' => [
                'nullable',
                'string',
                'max:255',
                Rule::unique('employees', 'company_mobile_number')->ignore($employee->id)
            ],

            'personal_number' => [
                'nullable',
                'string',
                'max:255',
                Rule::unique('employees', 'personal_number')->ignore($employee->id)
            ],

            'other_number' => [
                'nullable',
                'string',
                'max:255',
                Rule::unique('employees', 'other_number')->ignore($employee->id)
            ],

            'home_country_number' => [
                'nullable',
                'string',
                'max:255',
                Rule::unique('employees', 'home_country_number')->ignore($employee->id)
            ],
            'company_email' => 'nullable|email|max:255',
            'personal_email' => 'nullable|email|max:255',
            'status' => 'nullable|in:active,inactive',
        ];
    }

}
