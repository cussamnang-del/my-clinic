@extends('layouts.app')

@section('content')
  <div class="container py-5">
    <div class="row justify-content-center">
      <div class="col-md-8 col-lg-6">
        <div class="card shadow-sm border-0">
          <div class="card-body p-4">
            <h3 class="card-title mb-3">{{ __('Set up two-factor authentication') }}</h3>
            <p class="text-muted">
              {{ __('Scan the QR code below with an authenticator app (Google Authenticator, Authy, 1Password, etc.) and then enter the 6-digit code shown in the app.') }}
            </p>

            <div class="text-center my-4">
              <img src="{{ $qrCodeDataUri }}" alt="{{ __('2FA QR code') }}" class="img-fluid">
            </div>

            <div class="mb-4">
              <small class="text-muted d-block mb-1">{{ __('Manual entry secret (only if you cannot scan):') }}</small>
              <code class="user-select-all">{{ $secret }}</code>
            </div>

            @if (!empty($recoveryCodes))
              <div class="alert alert-warning small mb-4">
                <strong>{{ __('Save these recovery codes now.') }}</strong>
                {{ __('Each can be used once to log in if you lose your authenticator app. They will not be shown again.') }}
                <ul class="mb-0 mt-2 font-monospace">
                  @foreach ($recoveryCodes as $code)
                    <li>{{ $code }}</li>
                  @endforeach
                </ul>
              </div>
            @endif

            <form method="POST" action="{{ route('two-factor.confirm') }}" class="form-body">
              @csrf
              <div class="mb-3">
                <label for="code" class="form-label">{{ __('Authentication code') }}</label>
                <input id="code" name="code" type="text" inputmode="numeric" autocomplete="one-time-code"
                  pattern="[0-9]*" maxlength="6" required autofocus
                  class="form-control text-center font-monospace @error('code') is-invalid @enderror">
                @error('code')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>
              <button type="submit" class="btn btn-primary w-100">
                {{ __('Confirm and enable 2FA') }}
              </button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
