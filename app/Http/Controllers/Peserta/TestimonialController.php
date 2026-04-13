<?php

namespace App\Http\Controllers\Peserta;

use App\Http\Controllers\Controller;
use App\Http\Requests\Peserta\StoreTestimonialRequest;
use App\Models\Testimonial;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class TestimonialController extends Controller
{
    public function index(): View
    {
        return view('peserta.testimonials', [
            'testimonials' => auth()->user()->testimonials()->latest()->get(),
        ]);
    }

    public function store(StoreTestimonialRequest $request): RedirectResponse
    {
        Testimonial::create([
            'user_id' => auth()->id(),
            'rating' => $request->integer('rating'),
            'isi' => $request->validated()['isi'],
        ]);

        return back()->with('status', 'Testimoni berhasil dikirim.');
    }
}
