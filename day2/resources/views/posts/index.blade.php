<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laravel Blog - Day 2</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .header { background: #f8f9fa; padding: 20px; border-radius: 5px; margin-bottom: 20px; }
        .auth-links { float: right; }
        .auth-links a { margin-left: 10px; }
        .post { border: 1px solid #ddd; padding: 15px; margin-bottom: 15px; border-radius: 5px; }
        .post-title { font-size: 18px; font-weight: bold; margin-bottom: 10px; }
        .post-meta { color: #666; font-size: 14px; margin-bottom: 10px; }
        .post-excerpt { color: #333; }
        .no-posts { text-align: center; color: #666; padding: 40px; }
    </style>
</head>
<body>
    <div class="header">
        <h1>Laravel Blog Tutorial - Day 2</h1>
        <div class="auth-links">
            @auth
                <span>Welcome, {{ auth()->user()->name }}!</span>
                @if(auth()->user()->is_admin)
                    <a href="{{ route('admin.posts.index') }}">Admin</a>
                @endif
                <a href="{{ route('profile.edit') }}">Profile</a>
                <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                    @csrf
                    <button type="submit" style="background: none; border: none; color: blue; cursor: pointer;">Logout</button>
                </form>
            @else
                <a href="{{ route('login') }}">Login</a>
                <a href="{{ route('register') }}">Register</a>
            @endauth
        </div>
        <div style="clear: both;"></div>
    </div>

    <div class="content">
        @if($posts->count() > 0)
            @foreach($posts as $post)
                <div class="post">
                    <div class="post-title">
                        <a href="{{ route('posts.show', $post) }}">{{ $post->title }}</a>
                    </div>
                    <div class="post-meta">
                        By {{ $post->user->name }} on {{ $post->published_at->format('F j, Y') }}
                    </div>
                    @if($post->excerpt)
                        <div class="post-excerpt">{{ $post->excerpt }}</div>
                    @endif
                </div>
            @endforeach

            {{ $posts->links() }}
        @else
            <div class="no-posts">
                <h3>No posts yet!</h3>
                <p>The blog is ready for content. 
                @auth
                    @if(auth()->user()->is_admin)
                        <a href="{{ route('admin.posts.create') }}">Create your first post</a>
                    @endif
                @else
                    Please log in to see content.
                @endauth
                </p>
            </div>
        @endif
    </div>

    <div style="margin-top: 40px; padding: 20px; background: #f8f9fa; border-radius: 5px;">
        <h3>Day 2 Implementation Complete!</h3>
        <p><strong>Features implemented:</strong></p>
        <ul>
            <li>✅ Laravel Sanctum authentication</li>
            <li>✅ Database migrations for posts, comments, and users</li>
            <li>✅ Post and Comment models with relationships</li>
            <li>✅ Admin middleware and user roles</li>
            <li>✅ Authentication routes and controllers</li>
            <li>✅ Protected admin routes</li>
            <li>✅ Environment configuration</li>
        </ul>
        <p><strong>Next:</strong> Day 3 will implement database seeders, frontend styling, and more advanced features.</p>
    </div>
</body>
</html>