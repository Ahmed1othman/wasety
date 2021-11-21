<div class="menu">
    <div class="main-menu">
        <div class="scroll">
            <ul class="list-unstyled">
                <li class="active">
                    <a href="{{ route('home') }}">
                        <i class="iconsminds-shop-4"></i>
                        <span>{{ __('admin/app.dashboard') }}</span>
                    </a>
                </li>
                <li>
                    <a href="#users">
                         <i class="simple-icon-user-following"></i> <span class="d-inline-block">{{ __('admin/app.users') }}</span>
                    </a>

                </li>
                <li>
                    <a href="#projects">
                         <i class="iconsminds-project"></i> <span class="d-inline-block">{{ __('admin/app.projects') }}</span>
                    </a>

                </li>
                <li>
                    <a href="{{ route('products.index') }}">
                         <i class="iconsminds-project"></i> <span class="d-inline-block">{{ __('admin/app.products') }}</span>
                    </a>

                </li>
                <li>
                    <a href="#generalSetting">
                        <i class="iconsminds-air-balloon-1"></i> {{ __('admin/app.generalSetting') }}
                    </a>
                </li>

            </ul>
        </div>
    </div>

    <div class="sub-menu">
        <div class="scroll">

            <ul class="list-unstyled" data-link="users" id="users">

                <li>
                    <a href="{{ route('users.index') }}">
                        <i class="simple-icon-user-following"></i> <span class="d-inline-block">{{ __('admin/app.users') }}</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('partners.index') }}">
                        <i class="iconsminds-digital-drawing"></i> <span class="d-inline-block">{{ __('admin/app.partners') }}</span>
                    </a>
                </li>
            </ul>
            <ul class="list-unstyled" data-link="generalSetting">
                <li>
                    <a href="{{ route('info.index') }}">
                        <i class="simple-icon-picture"></i> <span class="d-inline-block">{{ __('admin/app.website_settings') }}</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('payments.index') }}">
                        <i class="simple-icon-picture"></i> <span class="d-inline-block">{{ __('admin/app.payments_settings') }}</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('contacts.index') }}">
                        <i class="simple-icon-bubbles"></i> <span class="d-inline-block">{{ __('admin/app.contacts') }}</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('countries.index') }}">
                        <i class="simple-icon-flag"></i> <span class="d-inline-block">{{ __('admin/app.countries') }}</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('cities.index') }}">
                        <i class="simple-icon-flag"></i> <span class="d-inline-block">{{ __('admin/app.cities') }}</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('sliders.index') }}">
                        <i class="simple-icon-picture"></i> <span class="d-inline-block">{{ __('admin/app.sliders') }}</span>
                    </a>
                </li>
            </ul>
            <ul class="list-unstyled" data-link="projects">
                <li>
                    <a href="{{ route('projects.index') }}">
                        <i class="iconsminds-project"></i> <span class="d-inline-block">{{ __('admin/app.projects') }}</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('projects.request') }}">
                        <i class="iconsminds-project"></i> <span class="d-inline-block">{{ __('admin/app.projectss_request') }}</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('projects.implementation') }}">
                        <i class="iconsminds-project"></i> <span class="d-inline-block">{{ __('admin/app.projects_implementation') }}</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('projects.delivery') }}">
                        <i class="iconsminds-project"></i> <span class="d-inline-block">{{ __('admin/app.projects_delivery') }}</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('projects.history') }}">
                        <i class="iconsminds-project"></i> <span class="d-inline-block">{{ __('admin/app.projects_history') }}</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>
