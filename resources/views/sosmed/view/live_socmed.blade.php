<style>
    /* Profile Section */

    .profile {
        padding: 5rem 0;
    }

    .profile::after {
        content: "";
        display: block;
        clear: both;
    }

    .profile-image {
        float: left;
        width: calc(33.333% - 1rem);
        display: flex;
        justify-content: center;
        align-items: center;
        margin-right: 3rem;
    }

    .profile-image img {
        border-radius: 50%;
    }

    .profile-user-settings,
    .profile-stats,
    .profile-bio {
        float: left;
        width: calc(66.666% - 2rem);
    }

    .profile-user-settings {
        margin-top: 1.1rem;
    }

    .profile-user-name {
        display: inline-block;
        font-size: 3.2rem;
        font-weight: 300;
    }

    .profile-edit-btn {
        font-size: 1.4rem;
        line-height: 1.8;
        border: 0.1rem solid #dbdbdb;
        border-radius: 0.3rem;
        padding: 0 2.4rem;
        margin-left: 2rem;
    }

    .profile-settings-btn {
        font-size: 2rem;
        margin-left: 1rem;
    }

    .profile-stats {
        margin-top: 2.3rem;
    }

    .profile-stats li {
        display: inline-block;
        font-size: 1.6rem;
        line-height: 1.5;
        margin-right: 4rem;
        cursor: pointer;
    }

    .profile-stats li:last-of-type {
        margin-right: 0;
    }

    .profile-bio {
        font-size: 1.6rem;
        font-weight: 400;
        line-height: 1.5;
        margin-top: 2.3rem;
    }

    .profile-real-name,
    .profile-stat-count,
    .profile-edit-btn {
        font-weight: 600;
    }

    /* Gallery Section */

    .gallery {
        display: flex;
        flex-wrap: wrap;
        margin: -1rem -1rem;
        padding-bottom: 3rem;
    }

    .gallery-item {
        position: relative;
        flex: 1 0 22rem;
        margin: 1rem;
        color: #fff;
        cursor: pointer;
    }

    .gallery-item:hover .gallery-item-info,
    .gallery-item:focus .gallery-item-info {
        display: flex;
        justify-content: center;
        align-items: center;
        position: absolute;
        top: 0;
        width: 90%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.3);
    }

    .gallery-item-info {
        display: none;
    }

    .gallery-item-info li {
        display: inline-block;
        font-weight: 600;
    }

    .gallery-item-likes {
        margin-right: 2.2rem;
    }

    .gallery-item-type {
        position: absolute;
        top: 1rem;
        right: 1rem;
        font-size: 2.5rem;
        text-shadow: 0.2rem 0.2rem 0.2rem rgba(0, 0, 0, 0.1);
    }

    .fa-clone,
    .fa-comment {
        transform: rotateY(180deg);
    }

    .gallery-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    /* Loader */

    .loader {
        width: 5rem;
        height: 5rem;
        border: 0.6rem solid #999;
        border-bottom-color: transparent;
        border-radius: 50%;
        margin: 0 auto;
        animation: loader 500ms linear infinite;
    }

    /* Media Query */

    @media screen and (max-width: 40rem) {
        .profile {
            display: flex;
            flex-wrap: wrap;
            padding: 4rem 0;
        }

        .profile::after {
            display: none;
        }

        .profile-image,
        .profile-user-settings,
        .profile-bio,
        .profile-stats {
            float: none;
            width: auto;
        }

        .profile-image img {
            width: 7.7rem;
        }

        .profile-user-settings {
            flex-basis: calc(100% - 10.7rem);
            display: flex;
            flex-wrap: wrap;
            margin-top: 1rem;
        }

        .profile-user-name {
            
        }

        .profile-edit-btn {
            order: 1;
            padding: 0;
            text-align: center;
            margin-top: 1rem;
        }

        .profile-edit-btn {
            margin-left: 0;
        }

        .profile-bio {
            margin-top: 1.5rem;
        }

        .profile-edit-btn,
        .profile-bio,
        .profile-stats {
            flex-basis: 100%;
        }

        .profile-stats {
            order: 1;
            margin-top: 1.5rem;
        }

        .profile-stats ul {
            display: flex;
            text-align: center;
            padding: 1.2rem 0;
            border-top: 0.1rem solid #dadada;
            border-bottom: 0.1rem solid #dadada;
        }

        .profile-stats li {
            flex: 1;
            margin: 0;
        }

        .profile-stat-count {
            display: block;
        }
    }

    /* Spinner Animation */

    @keyframes loader {
        to {
            transform: rotate(360deg);
        }
    }

    /*

    The following code will only run if your browser supports CSS grid.

    Remove or comment-out the code block below to see how the browser will fall-back to flexbox & floated styling. 

    */

    @supports (display: grid) {
        .profile {
            display: grid;
            grid-template-columns: 1fr 2fr;
            grid-template-rows: repeat(3, auto);
            grid-column-gap: 3rem;
            align-items: center;
        }

        .profile-image {
            grid-row: 1 / -1;
        }

        .gallery {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(22rem, 1fr));
            grid-gap: 2rem;
        }

        .profile-image,
        .profile-user-settings,
        .profile-stats,
        .profile-bio,
        .gallery-item,
        .gallery {
            width: auto;
            margin: 0;
        }

        @media (max-width: 40rem) {
            .profile {
                grid-template-columns: auto 1fr;
                grid-row-gap: 1.5rem;
            }

            .profile-image {
                grid-row: 1 / 2;
            }

            .profile-user-settings {
                display: grid;
                grid-template-columns: auto 1fr;
                grid-gap: 1rem;
            }

            .profile-edit-btn,
            .profile-stats,
            .profile-bio {
                grid-column: 1 / -1;
            }

            .profile-user-settings,
            .profile-edit-btn,
            .profile-settings-btn,
            .profile-bio,
            .profile-stats {
                margin: 0;
            }
        }
    }
</style>


<div class="row">
    @foreach($sosmed as $row)
        @if($row->sosmed_id==1)
            <div class="col-lg-6">
                <div class="card card-accent-success">
                    <div class="card-header" bg-info>Twitter</div>
                    <div class="card-body">
                        <a class="twitter-timeline" data-height="600" data-theme="light" data-link-color="#E81C4F" href="https://twitter.com/{{$row->unit_sosmed_name}}?ref_src=twsrc%5Etfw">Tweets by {{$row->unit_sosmed_name}}</a> <script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>
                    </div>
                </div>
            </div>
        @endif

        @if($row->sosmed_id==2)
            <div class="col-lg-6">
                <div class="card card-accent-primary">
                    <div class="card-header">Facebook</div>
                    <div class="card-body">
                        <div id="fb-root"></div>
    
                        {!! facebookFrame($row->unit_sosmed_account_id) !!}
                    </div>
                </div>
            </div>
        @endif

        @if($row->sosmed_id==3)
            <div class="col-lg-6">
                <div class="card card-accent-warning">
                    <div class="card-header">Instagram</div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-3">
                                <div class="profile-image">
                                    <br><br>
                                    <img src="{{$account->getProfilePicUrl()}}" alt="" class="img-fluid">
                                </div>
                            </div>
                            <div class="col-lg-9">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="profile-user-settings">
                                            <h1 class="profile-user-name">{{$account->getUsername()}}</h1>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <span class="profile-stat-count">{{$account->getMediaCount()}}</span> posts
                                    </div>
                                    <div class="col-lg-4">
                                        <span class="profile-stat-count">{{$account->getFollowsCount()}}</span> followers
                                    </div>
                                    <div class="col-lg-4">
                                        <span class="profile-stat-count">{{$account->getFollowedByCount()}}</span> following
                                    </div>
                                    <div class="col-lg-12">
                                        {{$account->getFullName()}} <br>
                                        {{$account->getBiography()}}
                                    </div>
                                </div>
                            </div>
                        </div>

                        <hr>

                        <div class="row">
                            @foreach($medias as $media)
                                <div class="gallery-item col-lg-6" style="margin-bottom:15px">
                                    <img src="{{$media->getImageHighResolutionUrl()}}" class="gallery-image img-fluid" alt="">
                                    <div class="gallery-item-info">
                                        <ul>
                                            <li class="gallery-item-likes"><span class="visually-hidden">Likes:</span><i class="fa fa-heart" aria-hidden="true"></i> {{$media->getLikesCount()}}</li>
                                            <li class="gallery-item-comments"><span class="visually-hidden">Comments:</span><i class="fa fa-comment" aria-hidden="true"></i> {{$media->getCommentsCount()}}</li>
                                        </ul>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        @endif

        @if($row->sosmed_id==5)
            <div class="col-lg-6">
                <div class="card card-accent-info">
                    <div class="card-header">Website</div>
                    <div class="card-body">
                        <a href="{{$row->unit_sosmed_account_id}}" target="_blank">
                            <img src="{{asset('uploads/web/'.$row->unit_sosmed_name)}}" alt="" class="img-fluid" target="_blank">
                        </a>
                    </div>
                </div>
            </div>
        @endif
    @endforeach

    <div class="col-lg-6">
        <div class="card card-default" style="overflow:scroll">
            <div class="card-header">Youtube</div>
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-2">
                        @if($youtube_json!=null)
                            <img src="{{$youtube_json['snippet']['thumbnails']['default']['url']}}" alt="" class="img-responsive">
                        @endif
                    </div>
                    <div class="col-lg-6">
                        @if($youtube_json!=null)
                            @if(isset($youtube_json['snippet']['customUrl']))
                                @php 
                                    $url=$youtube_json['snippet']['customUrl'];
                                @endphp 
                            @else 
                                @php 
                                    $url="";
                                @endphp
                            @endif
                            <a href="https://youtube.com/{{$url}}" target="new target">
                                <h3>{{$youtube_json['snippet']['title']}}</h3>
                            </a>
                            <p class="text-muted">{{number_format($youtube_json['statistics']['subscriberCount'])}} subscriber</p>
                        @endif
                    </div>
                    <div class="col-lg-3">
                        @if($youtube_json!=null)
                            <a href="#" class="btn btn-youtube btn-danger">SUBSCRIBE {{number_format($youtube_json['statistics']['subscriberCount'])}}</a></a>
                        @endif
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-lg-6">
                        @if($youtube_json!=null)
                            <h5>Statistik</h5>
                            <p class="small">Bergabung pada : {{date('d F Y',strtotime($youtube_json['snippet']['publishedAt']))}}</p>
                            <p>{{number_format($youtube_json['statistics']['viewCount'])}} x penayangan</p>
                        @endif
                    </div>

                    @if($youtube_json!=null)
                        @if(isset($youtube_json['snippet']['country']))
                            <div class="col-lg-6">
                                <h5>Detail</h5>
                                <p class="text-muted">Lokasi : {{$youtube_json['snippet']['country']}}</p>
                            </div>
                        @endif
                    @endif
                </div>

                <hr>
                <div id="showYoutube">
                    <div class="row">
                        @if(is_array($youtube_activity))
                            @foreach($youtube_activity as $key=>$row)
                                @if($key<4)
                                    <div class="col-lg-6" style="margin-bottom:10px;">
                                        @if(isset($row['contentDetails']['upload']))
                                            {{youtubeUrl($row['contentDetails']['upload']['videoId'])}}
                                        @endif
                                    </div>
                                @endif
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>