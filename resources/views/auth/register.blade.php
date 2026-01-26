<x-layout-login>
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

                    <s-password-field
                        label="Password"
                        name="password"
                        required></s-password-field>

                    <s-password-field
                        label="Confirm Password"
                        name="password_confirmation"
                        required>
                    </s-password-field>



                    <s-choice-list
                        label="Role"
                        name="role"
                        details="The company assigned role.">
                        <s-choice value="admin">Admin</s-choice>
                        <s-choice value="employee">Employee</s-choice>
                    </s-choice-list>

                    <s-button type="submit" size="slim" variant="primary">
                        Register
                    </s-button>
                </s-stack>
            </form>
        </s-section>
    </s-page>
</x-layout-login>