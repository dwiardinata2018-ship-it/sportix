<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBookingRequest extends FormRequest
{
    /**
     * Menentukan apakah pengguna boleh melakukan booking.
     */
    public function authorize(): bool
    {
        return $this->user() !== null
            && $this->user()->role === 'user'
            && $this->user()->account_status === 'active';
    }

    /**
     * Aturan validasi data booking.
     */
    public function rules(): array
    {
        return [
            'venue_id' => [
                'required',
                'integer',
                'exists:venues,id',
            ],

            'unit_id' => [
                'required',
                'integer',
                'exists:venue_units,id',
            ],

            'date' => [
                'required',
                'date_format:Y-m-d',
                'after_or_equal:today',
            ],

            'start_time' => [
                'required',
                'date_format:H:i',
            ],

            'end_time' => [
                'required',
                'date_format:H:i',
                'after:start_time',
            ],

            'user_notes' => [
                'nullable',
                'string',
                'max:1000',
            ],
        ];
    }

    /**
     * Pesan kesalahan validasi dalam bahasa Indonesia.
     */
    public function messages(): array
    {
        return [
            'venue_id.required' => 'Venue wajib dipilih.',
            'venue_id.exists' => 'Venue tidak ditemukan.',
            'unit_id.required' => 'Unit olahraga wajib dipilih.',
            'unit_id.exists' => 'Unit olahraga tidak ditemukan.',
            'date.required' => 'Tanggal booking wajib diisi.',
            'date.after_or_equal' => 'Tanggal booking tidak boleh di masa lalu.',
            'start_time.required' => 'Jam mulai wajib diisi.',
            'end_time.required' => 'Jam selesai wajib diisi.',
            'end_time.after' => 'Jam selesai harus setelah jam mulai.',
            'user_notes.max' => 'Catatan maksimal 1000 karakter.',
        ];
    }
}
