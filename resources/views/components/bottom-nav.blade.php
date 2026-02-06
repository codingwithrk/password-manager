<native:bottom-nav label-visibility="labeled">
    <native:bottom-nav-item
            id="home"
            icon="home"
            label="Home"
            :url="route('home-screen')"
            :active="request()->routeIs('home-screen')"
    />
    <native:bottom-nav-item
            id="info"
            icon="info"
            label="Info"
            :url="route('info-screen')"
            :active="request()->routeIs('info-screen')"
    />
</native:bottom-nav>