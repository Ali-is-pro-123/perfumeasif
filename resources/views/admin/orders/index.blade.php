@extends('layouts.admin')
@section('title', 'Orders | Asif Raza Admin')
@section('content')
<div class="topbar">
  <div>
    <h1>Orders</h1>
    <p>Process customer orders and check reports by day, week, month, or custom dates.</p>
  </div>
  <div class="topbar-actions">
    <a class="btn light" href="{{ route('admin.orders') }}">Reset filters</a>
  </div>
</div>

<form class="card form-grid" method="GET" action="{{ route('admin.orders') }}">
  <label>Report period
    <select name="period">
      <option value="all" @selected($period === 'all')>All orders</option>
      <option value="today" @selected($period === 'today')>Today</option>
      <option value="week" @selected($period === 'week')>This week</option>
      <option value="month" @selected($period === 'month')>This month</option>
      <option value="custom" @selected($period === 'custom')>Custom dates</option>
    </select>
  </label>
  <label>Status
    <select name="status">
      <option value="">All statuses</option>
      @foreach($statuses as $orderStatus)
        <option value="{{ $orderStatus }}" @selected($status === $orderStatus)>{{ ucfirst($orderStatus) }}</option>
      @endforeach
    </select>
  </label>
  <label>From<input name="from" type="date" value="{{ $from }}"></label>
  <label>To<input name="to" type="date" value="{{ $to }}"></label>
  <div class="full actions">
    <button type="submit">Check report</button>
  </div>
</form>

<div class="grid">
  <div class="card stat-card"><span>Filtered</span><strong>{{ $report['count'] }}</strong><p>Matching current report</p></div>
  <div class="card stat-card"><span>Sales</span><strong>${{ number_format($report['total'], 0) }}</strong><p>Total in selected period</p></div>
  <div class="card stat-card"><span>Pending</span><strong>{{ $report['pending'] }}</strong><p>Need processing</p></div>
  <div class="card stat-card"><span>Completed</span><strong>{{ $report['completed'] }}</strong><p>Finished orders</p></div>
</div>

<div class="table-wrap">
  <table>
    <thead>
      <tr>
        <th>Order</th>
        <th>Customer</th>
        <th>Items</th>
        <th>Total</th>
        <th>Date</th>
        <th>Status</th>
        <th>Process</th>
      </tr>
    </thead>
    <tbody>
      @forelse($orders as $order)
        <tr>
          <td><strong>{{ $order->order_number }}</strong><br><span class="muted">{{ $order->address }}</span></td>
          <td>{{ $order->customer_name }}<br><span class="muted">{{ $order->email }}</span></td>
          <td>
            @foreach($order->items as $item)
              <div>{{ $item->product_name }} x {{ $item->quantity }}</div>
            @endforeach
          </td>
          <td>${{ number_format($order->total, 0) }}</td>
          <td>{{ $order->created_at->format('M d, Y') }}</td>
          <td><span class="badge on">{{ $order->statusLabel() }}</span></td>
          <td>
            <form method="POST" action="{{ route('admin.orders.update', $order) }}" class="actions">
              @csrf
              @method('PATCH')
              <select name="status">
                @foreach($statuses as $orderStatus)
                  <option value="{{ $orderStatus }}" @selected($order->status === $orderStatus)>{{ ucfirst($orderStatus) }}</option>
                @endforeach
              </select>
              <button type="submit">Update</button>
            </form>
          </td>
        </tr>
      @empty
        <tr><td colspan="7"><div class="empty">No orders found for this report.</div></td></tr>
      @endforelse
    </tbody>
  </table>
</div>
@endsection
