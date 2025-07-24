@extends('layouts.app')
@section('content')
<main class="pt-90">
 
    <div class="mb-4 pb-4"></div>
    <section class="contact-us container">
      <div class="mw-930">
        <h2 class="page-title">CONTACT US</h2>
      </div>
    </section>
   




    <hr class="mt-2 text-secondary " />
    <div class="mb-4 pb-4"></div>

    <section class="contact-us container">
      <div class="mw-930">
        <div class="contact-us__form">
            <form action="{{ route('home.contactStore') }}" name="contact-us-form" class="needs-validation" novalidate method="POST">
                @csrf
                <h3 class="mb-5">Get In Touch</h3>
                    {{-- Success Message --}}
     @if (session('success'))
     <div class="alert alert-success text-center text-xl mt-4">
         {{ session('success') }}
     </div>
 @endif
            
                {{-- Name --}}
                <div class="form-floating my-4">
                    <input 
                        type="text" 
                        class="form-control" 
                        id="contact_us_name" 
                        name="name" 
                        placeholder="Name *" 
                        value="{{ old('name') }}" 
                        required
                    >
                    <label for="contact_us_name">Name *</label>
                    @error('name')
                        <span class="text-red">{{ $message }}</span>
                    @enderror
                </div>
            
                {{-- Phone --}}
                <div class="form-floating my-4">
                    <input 
                        type="text" 
                        class="form-control" 
                        id="contact_us_phone" 
                        name="phone" 
                        placeholder="Phone *" 
                        value="{{ old('phone') }}" 
                        required
                    >
                    <label for="contact_us_phone">Phone *</label>
                    @error('phone')
                        <span class="text-red">{{ $message }}</span>
                    @enderror
                </div>
            
                {{-- Email --}}
                <div class="form-floating my-4">
                    <input 
                        type="email" 
                        class="form-control" 
                        id="contact_us_email" 
                        name="email" 
                        placeholder="Email address *" 
                        value="{{ old('email') }}" 
                        required
                    >
                    <label for="contact_us_email">Email address *</label>
                    @error('email')
                        <span class="text-red">{{ $message }}</span>
                    @enderror
                </div>
            
                {{-- Message --}}
                <div class="my-4">
                    <label for="contact_us_message" class="form-label">Your Message *</label>
                    <textarea 
                        class="form-control form-control_gray" 
                        id="contact_us_message" 
                        name="comment" 
                        placeholder="Your Message" 
                        cols="30" 
                        rows="8" 
                        required
                    >{{ old('comment') }}</textarea>
                
                    @error('comment')
                    <div class="text-red fw-semibold">{{ $message }}</div>
                @enderror
                
                </div>                
            
                {{-- Submit --}}
                <div class="my-4">
                    <button type="submit" class="btn btn-primary w-100">Submit</button>
                </div>
            </form>
            
        </div>
      </div>
    </section>
  </main>  
@endsection