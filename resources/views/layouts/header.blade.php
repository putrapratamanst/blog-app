<header class="header-v4">
		<!-- Header desktop -->
		<div class="container-menu-desktop">
			<!-- Topbar -->
			<div class="top-bar">
				<div class="content-topbar flex-sb-m h-full container">
					<div class="left-top-bar">
						<!-- Free shipping for standard order over $100 -->
					</div>

					<div class="right-top-bar flex-w h-full">
                        @if (Auth::check())
                        <a class="flex-c-m trans-04 p-lr-25"> {{ Auth::user()->name }}</a>
                         <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-responsive-nav-link :href="route('logout')"
                                    class="flex-c-m trans-04 p-lr-25"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();" >
                                {{ __('Log Out') }}
                            </x-responsive-nav-link>
                        </form>
                        @else
                            <a class="flex-c-m trans-04 p-lr-25" href="{{ route('login') }}">Login</a>
                        @endif
					</div>
				</div>
			</div>

		</div>
        <div class="wrap-menu-desktop how-shadow1">
				<nav class="limiter-menu-desktop container">
					
					<!-- Menu desktop -->
					<div class="menu-desktop">
						<ul class="main-menu">
							<li>
								<a href="/">Home</a>
							</li>
						</ul>
					</div>	

					
				</nav>
			</div>	

		<!-- Menu Mobile -->
		<div class="menu-mobile">
			<ul class="topbar-mobile">

				<li>
					<div class="right-top-bar flex-w h-full">

						<a href="#" class="flex-c-m p-lr-10 trans-04">
							My Account
						</a>

					</div>
				</li>
			</ul>

			<ul class="main-menu-m">
				<li>
					<a href="/">Home</a>
				</li>

			</ul>
		</div>

	</header>