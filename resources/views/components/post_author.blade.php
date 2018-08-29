<div class="author-info">
    <div class="author-nickname"><a href="">{{ $author->nickname }}</a></div>
    <div class="author-avatar">
        <a href=""><img src="{{ $author->avatar_url }}"
                        alt="{{ $author->nickname }}头像"/></a>
    </div>
    <p><a href="">level 1</a></p>
    <dl class="user-meta">
        <dt>ID</dt>
        <dd><a href="">{{ $author->id }}</a></dd>
        <dt>金币</dt>
        <dd><a href="">{{ $author->coin_count }}</a></dd>
        <dt>经验值</dt>
        <dd><a href="">{{ $author->exp_count }}</a></dd>
    </dl>
</div>
