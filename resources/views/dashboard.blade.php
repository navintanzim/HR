<x-layout>
  

  <s-page>
    <s-section>

      @if (session('success'))
      <s-banner tone="success">
        {{ session('success') }}
      </s-banner>
      @endif

      @if (session('error'))
      <s-banner tone="critical">
        {{ session('error') }}
      </s-banner>
      @endif

      <h1>Welcome, {{ Auth::user()->name }}!</h1>
      <p>This is your dashboard.</p>


        <s-section>
          @if(Auth::user()->role =='505')
          <s-text type="strong" style="margin-bottom: 8px;">Your Pending Leave Requests: {{count($leave_request)}}</s-text>
          @else
          <s-text type="strong" style="margin-bottom: 8px;">Pending Leave Requests: {{count($leave_request)}}</s-text>
          @endif
         
        </s-section>


      <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit">Logout</button>
      </form>
    </s-section>
  </s-page>


</x-layout>