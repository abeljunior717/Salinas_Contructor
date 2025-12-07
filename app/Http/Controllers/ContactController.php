<?php

namespace App\Http\Controllers;

use App\Models\Message;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function index()
    {
        return view('contact.index');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|max:100',
            'message' => 'required|string|min:10|max:1000',
        ]);

        // Guardar mensaje en base de datos
        Message::create($validated);
        
        return redirect()->back()
                       ->with('success', '¡Mensaje enviado! Nos pondremos en contacto pronto.');
    }
}
