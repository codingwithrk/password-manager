<native:top-bar title="Password manager" :show-navigation-icon="false" elevation="24">
    @if(request()->routeIs('home-screen'))
        <native:top-bar-action
                id="refresh-home-screen"
                label="Refresh home screen"
                icon="refresh"
                :url="route('home-screen')"/>
        <native:top-bar-action
                id="add"
                label="Add password"
                icon="plus"
                :url="route('add-new-password')"/>
    @endif
    @if(request()->routeIs('add-new-password'))
        <native:top-bar-action
                id="home-screen"
                label="Home screen"
                icon="home"
                :url="route('home-screen')"/>
    @endif
</native:top-bar>