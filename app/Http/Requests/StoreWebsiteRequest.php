<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreWebsiteRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user('admin') !== null;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'id_template' => ['required', 'integer', 'exists:templates,id_template'],
            'nama_website' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'max:80', 'regex:/^[a-z0-9]+(?:-[a-z0-9]+)*$/', Rule::unique('websites', 'slug')],
            'bio' => ['required', 'string', 'max:1000'],
            'logo' => ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'foto_pribadi' => ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
            'gallery' => ['required', 'array', 'size:5'],
            'gallery.*' => ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
            'products' => ['required', 'array', 'size:3'],
            'products.*.nama_produk' => ['required', 'string', 'max:255'],
            'products.*.harga' => ['required', 'integer', 'min:0'],
            'products.*.fasilitas' => ['required', 'string', 'max:1000'],
            'whatsapp' => ['required', 'string', 'max:100'],
            'instagram' => ['required', 'string', 'max:100'],
            'pinterest' => ['required', 'string', 'max:100'],
        ];
    }
}
