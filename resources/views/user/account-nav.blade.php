<ul class="account-nav">
    <li><a href="{{ route('user.index') }}" class="menu-link menu-link_us-s">Dashboard</a></li>
    <li><a href="{{route('users.orders')}}" class="menu-link menu-link_us-s">Orders</a></li>
    <li><a href="account-address.html" class="menu-link menu-link_us-s">Addresses</a></li>
    <li><a href="account-details.html" class="menu-link menu-link_us-s">Account Details</a></li>
    <li><a href="account-wishlist.html" class="menu-link menu-link_us-s">Wishlist</a></li>
    <form action="{{ route('user.logout') }}" method="POST" id="userLogoutForm">
        @csrf
        <li><a type="submit" href="{{ route('user.logout') }}"
                onclick="event.preventDefault();document.getElementById('userLogoutForm').submit();
    "
                class="menu-link menu-link_us-s">Logout</a></li>
    </form>
</ul>
