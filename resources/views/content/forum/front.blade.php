<div class="row">

    @foreach ($contents as $index => $content)

        <div class="col-sm-4">

            @include('component.row', [
                'image' => $content->user->imagePath(),
                'image_link' => '/user/' . $content->user->id,
                'heading' => $content->title,
                'heading_link' => '/content/' . $content->id,
                'text' => 'By <a href="/user/' . $content->user->id .'">'
                    . $content->user->name
                    . '</a> created at '
                    . $content->created_at->format('d. m Y H:i:s')
                    . '</a> latest comment at '
                    . $content->updated_at->format('d. m Y H:i:s')
            ])

        </div>

    @endforeach

</div>