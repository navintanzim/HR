<x-layout>
    <s-page>
        <s-section>
            <form method="POST" action="{{ route('register') }}">
                @csrf
                <s-stack spacing="loose">
                    <s-text-field
                        label="Name"
                        name="name"
                        value="{{ old('name') }}"
                        required></s-text-field>

                    <s-text-field
                        label="Email"
                        type="email"
                        name="email"
                        value="{{ old('email') }}"
                        required></s-text-field>

                    <s-text-field
                        label="Password"
                        type="password"
                        name="password"
                        required></s-text-field>

                    <s-button type="submit" size="slim" variant="primary">
                        Register
                    </s-button>
                </s-stack>
            </form>
        </s-section>
    </s-page>
</x-layout>