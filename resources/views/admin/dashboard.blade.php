@extends('layouts.admin')
@section('title', 'Dashboard | Asif Raza Admin')
@section('content')
<div class="topbar">
  <div>
    <h1>Dashboard</h1>
    <p>Manage products, carousel content, and customer messages.</p>
  </div>
  <div class="topbar-actions">
    <a class="btn light" href="{{ route('home') }}">View site</a>
    <a class="btn" href="{{ route('admin.products.create') }}">Add product</a>
  </div>
</div>
<div class="grid">
  <div class="card stat-card"><span>Products</span><strong>{{ $productsCount }}</strong><p>Total perfumes in catalog</p></div>
  <div class="card stat-card"><span>Categories</span><strong>{{ $categoriesCount }}</strong><p>Dynamic shop categories</p></div>
  <div class="card stat-card"><span>Orders</span><strong>{{ $ordersCount }}</strong><p>Total customer orders</p></div>
  <div class="card stat-card"><span>Pending</span><strong>{{ $pendingOrders }}</strong><p>Orders waiting process</p></div>
  <div class="card stat-card"><span>Messages</span><strong>{{ $messagesCount }}</strong><p>Customer inquiries received</p></div>
  <div class="card stat-card"><span>Unread</span><strong>{{ $unreadMessages }}</strong><p>Needs admin attention</p></div>
</div>
<div class="panel-grid">
  <div class="card">
    <h2>Latest orders</h2>
    <div class="quick-list">
      @forelse($latestOrders as $order)
        <a href="{{ route('admin.orders') }}">
          <strong>{{ $order->order_number }} - {{ $order->customer_name }}</strong>
          <span>${{ number_format($order->total, 0) }}</span>
        </a>
      @empty
        <div class="empty">No orders yet.</div>
      @endforelse
    </div>
  </div>
  <div class="card">
    <h2>Latest messages</h2>
    <div class="quick-list">
      @forelse($latestMessages as $message)
        <div class="message-row">
          <div>
            <strong>{{ $message->name }}</strong>
            <p>{{ $message->email }}</p>
          </div>
          <small>{{ $message->created_at->format('M d') }}</small>
        </div>
      @empty
        <div class="empty">No messages yet.</div>
      @endforelse
    </div>
  </div>
  <div class="card">
    <h2>Quick actions</h2>
    <div class="quick-list">
      <a href="{{ route('admin.products.create') }}"><strong>Add new perfume</strong><span>+</span></a>
      <a href="{{ route('admin.categories.create') }}"><strong>Add new category</strong><span>+</span></a>
      <a href="{{ route('admin.products') }}"><strong>Edit product images</strong><span>→</span></a>
      <a href="{{ route('admin.messages') }}"><strong>Read messages</strong><span>→</span></a>
    </div>
  </div>
</div>
@endsection
