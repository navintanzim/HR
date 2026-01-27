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

            <h1 class="text-xl font-bold mb-4">Users</h1>

            <div style="display: flex;justify-content: flex-end; padding: 10px;">
                <s-button
                    variant="primary"
                    size="slim"
                    outline
                    onclick="window.location.href='{{ route('register') }}'">
                    Create New Accounts
                </s-button>
            </div>

            <s-table>
                <s-table-header-row>

                    <s-table-header>User ID</s-table-header>
                    <s-table-header>User Name</s-table-header>
                    <s-table-header>Email</s-table-header>
                    <s-table-header>Role</s-table-header>
                    <s-table-header>Type</s-table-header>

                </s-table-header-row>

                <s-table-body>
                    @forelse ($users as $user)
                    <s-table-row>
                        <s-table-cell>{{ $user->employee_id }}</s-table-cell>
                        <s-table-cell>{{ $user->name }}</s-table-cell>
                        <s-table-cell>{{ $user->email }}</s-table-cell>
                        <s-table-cell>{{ $user->role }}</s-table-cell>
                        <s-table-cell>@if($user->role=='505')Employee @else Admin @endif</s-table-cell>
                    </s-table-row>
                    @empty
                    <s-table-row>
                        <s-table-cell colspan="5">
                            <s-text>No records found.</s-text>
                        </s-table-cell>
                    </s-table-row>
                    @endforelse
                </s-table-body>
            </s-table>

        </s-section>
    </s-page>
</x-layout>