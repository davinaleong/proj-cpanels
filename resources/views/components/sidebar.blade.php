<aside class="bg-light">
    <nav class="nav flex-column">
        <a class="nav-link" href="{{ route('activities.index') }}"><i class="fas fa-file-alt fa-fw"></i> Activity</a>
        <a class="nav-link" href="#"><i class="fas fa-boxes fa-fw"></i> Projects</a>
        <a class="nav-link" href="{{ route('cpanels.index') }}"><i class="fas fa-server fa-fw"></i> CPanels</a>
        <a class="nav-link" href="{{ route('additionalData.index') }}"><i class="fas fa-table fa-fw"></i> Additional Data</a>
        <a class="nav-link" href="{{ route('settings.index') }}"><i class="fas fa-cogs fa-fw"></i> Settings</a>
        <div class="nav-link">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <a href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();">
                    <i class="fas fa-sign-out-alt fa-fw"></i> Logout
                </a>
            </form>
        </div>
    </nav>
</aside>
