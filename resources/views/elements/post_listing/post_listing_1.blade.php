 @forelse($blogs as $blog)
                    <div class="dz-card default-el-1 blog-half overlay-shine m-b40">
                        <div class="dz-media">
                            <a href="{{ DzHelper::laraBlogLink($blog->id) }}">
                                @if(optional($blog->feature_img)->value && Storage::exists('public/blog-images/'.$blog->feature_img->value))
                                    <img src="{{ asset('storage/blog-images/'.$blog->feature_img->value) }}" alt="">
                                @else
                                    <img src="{{ asset('images/noimage.jpg') }}" alt="">
                                @endif
                            </a>
                        </div>

                        <div class="dz-info">
                            <div class="dz-meta">
                                <ul>
                                    <li class="post-author">
                                        <img src="{{ HelpDesk::user_img($blog->user->profile) }}" alt="">
                                        {{ $blog->user->name }}
                                    </li>
                                    <li class="post-date">
                                        {{ Carbon\Carbon::parse($blog->publish_on)->format(config('Site.custom_date_format')) }}
                                    </li>
                                    <li class="post-comment">
                                        {{ $blog->blog_comments_count }} {{ __('Comments') }}
                                    </li>
                                </ul>
                            </div>

                            <h4 class="dz-title">
                                <a href="{{ DzHelper::laraBlogLink($blog->id) }}">
                                    {{ Str::limit($blog->title, 40) }}
                                </a>
                            </h4>

                            <p>{{ Str::limit($blog->excerpt, 80) }}</p>

                            <a href="{{ DzHelper::laraBlogLink($blog->id) }}" class="read-more-btn bg-primary">
                                {{ __('Read More') }}
                            </a>
                        </div>
                    </div>
                @empty
                    <p>{{ __('No blogs found') }}</p>
                @endforelse