<div class="side-menu sidebar-inverse">
    <nav class="navbar navbar-default" role="navigation">
        <div class="side-menu-container">
            <div class="navbar-header">
                <a class="navbar-brand" href="{{ route('voyager.dashboard') }}">
                    <div class="logo-icon-container">
                        <?php $admin_logo_img = Voyager::setting('admin.icon_image', ''); ?>
                        @if($admin_logo_img == '')
                            <img src="{{ voyager_asset('images/internet-3.png') }}" alt="Logo Icon">
                        @else
                            <img src="{{ Voyager::image($admin_logo_img) }}" alt="Logo Icon">
                        @endif
                    </div>
                    {{-- <div class="title">{{Voyager::setting('admin.title', 'VOYAGER')}}</div> --}}
                    <div class="title" style="text-transform: capitalize; font-weight: bold;">
                        {{ ucwords(Voyager::setting('admin.title', 'VOYAGER')) }}
                    </div>
                    
                </a>
            </div><!-- .navbar-header -->

            <div class="panel widget center bgimage"
                 style="background-image:url({{ Voyager::image( Voyager::setting('admin.bg_image'), voyager_asset('images/smart-office-desk.png') ) }}); background-size: cover; background-position: 0px;">
                <div class="dimmer"></div>
                <div class="panel-content">
                    <img src="{{ $user_avatar }}" class="avatar" alt="{{ Auth::user()->name }} avatar">
                    <h4>{{ ucwords(Auth::user()->name) }}</h4>
                    <p>{{ Auth::user()->email }}</p>

                    <a href="{{ route('voyager.profile') }}" class="btn btn-primary">{{ __('voyager::generic.profile') }}</a>
                    <div style="clear:both"></div>
                </div>
            </div>

        </div>

        {{-- this is the default sidebar items --}}
        
        <div id="adminmenu">
            <admin-menu :items="{{ menu('admin', '_json') }}"></admin-menu>            

        </div>

        {{-- <div id="adminmenu">
            @php
                $menuName = 'admin';
                $menu = TCG\Voyager\Models\Menu::where('name', $menuName)->firstOrFail();
        
                // Set the default $exceptItems array
                $exceptItems = [
                    'Media',
                    'Compass',
                    'Settings',
                    'Tools',
                    'Menu Builder'
                ];
        
                // Check if the user is a normal user and update the $exceptItems array
                if (Auth::user()->role_id != 1) {
                    $exceptItems = [
                        'Media',
                        'Compass',
                        'Settings',
                        'Tools',
                        'Menu Builder',
                        'Users',
                        'Roles',
                        'Database',
                        'BRAED Operations'
                    ];
                }
        
                $menuItems = $menu->items->reject(function($item) use ($exceptItems) {
                    return in_array($item->title, $exceptItems);
                });
            @endphp
            <ul class="nav navbar-nav">
                @foreach($menuItems as $item)
                    <li class="">
                        <a class="nav-link" href="{{ $item->link() }}">
                            <span class="icon {{ $item->icon_class }}"></span>
                            <span class="title" >{{ $item->title }}</span>
                        </a>
                    </li>
                @endforeach
            </ul>
        </div> --}}
        
    </nav>
</div>
