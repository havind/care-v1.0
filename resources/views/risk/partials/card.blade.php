<div class="col mb-3">
    <div class="card">
        <a class="card-link" href="{{ route($link) }}">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-2">
                        <svg width="30" height="30" style="margin: 5px;">
                            <circle cx="15" cy="15" r="15" fill="#f4b223"/>
                            <text x="50%" y="50%" text-anchor="middle" fill="white" font-size="15" font-family="Arial" dy=".35em">{{ $title_small }}
                            </text>
                            Sorry, your browser does not support inline SVG.
                        </svg>
                    </div>
                    <div class="col-md-10 d-flex align-items-center">
                        <span class="align-middle">{{ $title }}</span>
                    </div>
                </div>
            </div>
        </a>
    </div>
</div>
