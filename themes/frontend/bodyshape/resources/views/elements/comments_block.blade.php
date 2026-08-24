
@php
    $enable_comment = false;
    $object = '';
    $objectUrl = '#';

    if (isset($page) && !empty($page->comment)) {
        $enable_comment = true;
        $object = $page;
        $objectUrl = DzHelper::laraPageLink($object->id);
    }
    if (isset($blog) && !empty($blog->comment)) {
        $enable_comment = true;
        $object = $blog;
        $objectUrl = DzHelper::laraBlogLink($object->id);
    }
@endphp

@if ($enable_comment)
    <div class="{{ isset($page) ? 'container' : '' }} clear" id="comment-list">
        <div class="comments-area style-1 clearfix" id="comments-div">
            <div class="widget-title">
                <h4 class="title">@if ($comment_count_on){{ $total_comments }}@endif {{ _('COMMENTS') }}</h4>
            </div>
            @if($comments->isNotEmpty() && $comment_view_on)
                <div class="clearfix">
                    <ol class="comment-list mb-0">
                        @forelse($comments as $comment)
                            <li class="comment">
                                <div class="comment-body">
                                    <div class="comment-author vcard">
                                        @if (optional($comment->user)->profile && Storage::exists('public/user-images/'.$comment->user->profile))
                                            <img class="avatar photo" src="{{ asset('storage/user-images/'.$comment->user->profile) }}" alt="">
                                        @else
                                            <img class="avatar photo" src="{{ asset('images/no-user.png') }}" alt="">
                                        @endif
                                    </div>
                                    <div class="comment-info">
                                        <div class="title">
                                            <cite class="fn">
                                                {{ $comment->commenter }}
                                            </cite>
                                            <span>{{ \Carbon\Carbon::parse($comment->created_at) }}</span>
                                        </div>
                                        <p>{{ $comment->comment }}</p>
                                        <div class="reply">
                                            <a rel="nofollow" href="{{ $objectUrl }}?replytocom={{ $comment->id }}#respond" class="comment-reply-link w3-comment-reply" data-commentid="{{ $comment->id }}" data-postid="{{ $object->id }}"  data-replyto="Reply to {{ $comment->commenter }}">
                                                <span>
                                                    <i class="fa fa-reply"></i>
                                                    {{ __('REPLY') }}
                                                </span>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                @if (isset($comment->child_comments) && $comment->child_comments->isNotEmpty())
                                    @include('elements.child_comments', ['comments' => $comment->child_comments,'parent_comment' => $comment->commenter, 'depth' => 1])
                                @endif
                            </li>
                        @empty
                        @endforelse
                    </ol>
                    <div class="mb-4">
                        @if(config('Discussion.page_comments'))
                            {!! $comments->links('elements.pagination') !!}
                        @endif
                    </div>
                </div>
            @endif
            @if(!config('Discussion.registration_comment'))
                <div id="ReplyFormContainer">
                    @if(Session::has('unapprove_comment_error'))
                        <div class="alert alert-danger alert-dismissible alert-alt fade show">
                            <strong>{{ __('common.error') }}</strong> {{ Session::get('unapprove_comment_error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="btn-close">
                        </div>
                    @endif
                    <div class="widget-title">
                        <h4 class="title">{{ __('Leave A Reply') }}</h4>
                    </div>
                    <h5>
                        <span id="reply-title"></span>
                        <small class="fw-normal"> <a rel="nofollow" class="d-none" id="cancel-comment-reply" href="{{ $objectUrl }}#respond">{{ __('Cancel reply') }}</a> </small>
                    </h5>
                    @auth
                        <p> {{ __('You are Logged in as') }} <a href="{{ route('admin.users.profile') }}">{{ Auth::user()->name }}</a></p>
                    @endauth

                    <div class="clearfix">
                        <!-- Form -->
                        <div class="default-form comment-respond style-1" id="respond">
                            <form action="{{ route('home.comments.store') }}" class="comment-form row" id="commentform" method="post">
                                @csrf
                                <div class="container">
                                    @error('commenter')
                                        <div class="alert alert-primary alert-dismissible fade show" role="alert">
                                            {{ $message }}
                                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                        </div>
                                    @enderror
                                    @error('email')
                                        <div class="alert alert-primary alert-dismissible fade show" role="alert">
                                            {{ $message }}
                                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                        </div>
                                    @enderror
                                    @error('comment')
                                        <div class="alert alert-primary alert-dismissible fade show" role="alert">
                                            {{ $message }}
                                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                        </div>
                                    @enderror
                                </div>
                                @if( Session::get('success'))
                                    <p class="m-b30">
                                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                                            {{ Session::get('success') }}
                                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                        </div>
                                    </p>
                                @endif
                                <input type="hidden" name="object_id" value="{{ $object->id }}">
                                <input type="hidden" name="parent_id" id="comment_parent" value="0">

                                @guest
                                    <div class="row">
                                        <p class="comment-form-author">
                                            <label>{{ __('Name') }} {!! $requiredFieldIndicator !!}</label>
                                            <input type="text" name="commenter" placeholder="{{ __('Name') }}" id="commenter" value="{{ old('commenter', $comment_author) }}" {{ $isRequired }}>
                                        </p>
                                        <p class="comment-form-email">
                                            <label>{{ __('Email') }} {!! $requiredFieldIndicator !!}</label>
                                            <input type="email" placeholder="{{ __('Email') }}" name="email" id="email" value="{{ old('email', $comment_email) }}" {{ $isRequired }}>
                                        </p>
                                        <p class="comment-form-email w-100">
                                            <label>{{ __('Website url') }}</label>
                                            <input type="url" placeholder="{{ __('Website url') }}" name="profile_url" id="profileurl" value="{{ old('profile_url', $comment_url) }}">
                                        </p>
                                    </div>
                                @endguest
                                <p class="comment-form-comment">
                                    <label>{{ __('Message') }}</label>
                                    <textarea rows="8" name="comment" placeholder="{{ __('Comment') }}" id="comment">{{ old('comment') }}</textarea>
                                </p>
                                @guest
                                    @if(config('Discussion.save_comments_cookie'))
                                        <p class="comment-form-comment">
                                            <label class="form-check-label d-block">
                                                <input type="checkbox" name="set_comment_cookie" class="form-check-input" @checked($comment_author || $comment_email || $comment_url)>
                                                {{ __('Remember details for future comments: Name, Email, and Website.') }}
                                            </label>
                                        </p>
                                    @endif
                                @endguest
                                <p class="form-submit">
                                    <button type="submit" class="btn btn-primary btn-skew btn-icon" id="submit"><span>{{ __('Submit Now') }}</span></button>
                                </p>
                            </form>
                        </div>
                        <!-- Form -->
                    </div>


                </div>
            @else
                <p>{{ __('Please') }} <a href="{{ route('admin.login') }}">{{ __('log in') }}</a> {{ __('to post a comment.') }}</p>
            @endif
            <!-- Form END -->
        </div>
    </div>
@endif
