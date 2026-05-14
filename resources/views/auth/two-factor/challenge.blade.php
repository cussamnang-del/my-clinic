@extends('layouts.app')

@section('content')
  <div class="container py-5">
    <div class="row justify-content-center">
      <div class="col-md-6 col-lg-5">
        <div class="card shadow-sm border-0">
          <div class="card-body p-4">
            <h3 class="card-title mb-3">{{ __('Two-factor authentication') }}</h3>
            <p class="text-muted">
              {{ __('Enter the 6-digit code from your authenticator app, or use one of your recovery codes.') }}
            </p>

            <form method="POST" action="{{ route('two-factor.verify') }}" class="form-body">
              @csrf

              <div class="mb-3">
                <label for="code" class="form-label">{{ __('Authentication code') }}</label>
                <input id="code" name="code" type="text" inputmode="numeric" autocomplete="one-time-code"
                  pattern="[0-9]*" maxlength="6" autofocus
                  class="form-control text-center font-monospace @error('code') is-invalid @enderror">
                @error('code')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>

              <div class="mb-3">
                <label for="recovery_code" class="form-label">
                  {{ __('Or recovery code') }}
                </label>
                <input id="recovery_code" name="recovery_code" type="text" maxlength="32"
                  class="form-control text-center font-monospace">
              </div>

              <button type="submit" class="btn btn-primary w-100">
                {{ __('Verify') }}
              </button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
