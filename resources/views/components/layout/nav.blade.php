<nav class="border-b border-border px-6 ">
    <div class="max-w-7xl mx-auto h-16 flex items-center justify-between">
        <div>
            <a href="/">
                <x-layout.logo-svg/>
            </a>
        </div>
        <div class="flex gap-x-5 items-center">
            @auth
                <a href="/profile">My Profile</a> 
                <form action="/logout" method="POST">
                    @csrf
                    @method('DELETE')
                    <button class="btn bg-red-500">Log Out</button>
                </form>
            @endauth
            @guest
                <a href="/login">Sign In</a>
                <a href="/register" class="btn">Register</a>
            @endguest
        </div>
    </div>
</nav>
