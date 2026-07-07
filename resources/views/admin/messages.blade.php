@extends('layouts.admin')
@section('title', 'Messages | Asif Raza Admin')
@section('content')
<div class="topbar">
  <div>
    <h1>Contact Messages</h1>
    <p>Customer inquiries from the public contact form.</p>
  </div>
  <a class="btn light" href="{{ route('admin.dashboard') }}">Back dashboard</a>
</div>
<div class="message-list">
  @forelse($messages as $message)
    <div class="card message-card">
      <h3><span>{{ $message->name }}</span><small>{{ $message->created_at->format('M d, Y h:i A') }}</small></h3>
      <small class="muted">{{ $message->email }}</small>
      @if($message->address)
        <p><strong>Address:</strong> {{ $message->address }}</p>
      @endif
      <p>{{ $message->message }}</p>
    </div>
  @empty
    <div class="card empty">No messages yet.</div>
  @endforelse
</div>
@endsection
