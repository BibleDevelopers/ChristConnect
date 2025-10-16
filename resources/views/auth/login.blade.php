<x-layout>
    <form method="POST" action="{{ route('login.attempt') }}">
        @csrf
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit">Submit</button>
    </form>
</x-layout>