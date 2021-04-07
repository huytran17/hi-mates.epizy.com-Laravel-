<li class="msg-item {{ $attributes['class'] }}" id="{{ $msg->encrypted_id }}">
	<div class="sender">
		<span>{{ $msg->nickname===null ? $msg->user->name : $msg->nickname }}</span>
		<p>
			<img src="{{ $msg->user->profile_photo_path }}" alt="{{ $msg->user->slug }}" data-toggle="tooltip" title="{{ $msg->nickname===null ? $msg->user->name : $msg->nickname }}">
		</p>
	</div>

	<div class="msg-content" style="{{ $attributes['style'] }}">
		@if(!empty($msg->parent_id))
			<p class="reply">
				<span class="msg-rep">
					<span>
						Trả lời <strong>{{ $msg->parent->nickname === null ? $msg->parent->user->name : $msg->parent->nickname }}</strong>: 
					</span>
					@if ($msg->parent->deleted_at!==null) <small><i>Tin nhắn đã xóa</i></small>
					@else
						@if (substr($msg->parent->content, 0, 11) === 'data:image/')
							<a href="#" class="move-link" id="{{ $msg->parent->encrypted_id }}">Hình ảnh</a>
						@elseif (substr(substr($msg->parent->content, strpos($msg->parent->content, '+end+')+5), 0, 14) === 'data:audio/wav')
							<a href="#" class="move-link" id="{{ $msg->parent->encrypted_id }}">Audio</a>
						@elseif (substr(substr($msg->parent->content, strpos($msg->parent->content, '+end+')+5), 0, 11) === 'data:@file/')
							<a href="#" class="move-link" id="{{ $msg->parent->encrypted_id }}">Tài liệu</a>
						@else
							<span class="text-content">{!! $msg->parent->content !!}</span>
						@endif
					@endif
				</span>
			</p>
		@endif
		<p data-toggle="tooltip" data-placement="{{ $attributes['data-placement'] }}" title="{{ $msg->dmy_created_at }}" class="main-msg">
			<span class="content">
				@if ($msg->deleted_at!==null) <small><i>Tin nhắn đã xóa</i></small>
				@else
					@if (substr($msg->content, 0, 11) === 'data:image/')
						<img src="{{ $msg->content }}" alt="no-image">
					@elseif (substr(substr($msg->content, strpos($msg->content, '+end+')+5), 0, 14) === 'data:audio/wav')
						<audio src="{{ substr($msg->content, strpos($msg->content, '+end+')+5) }}" controls="controls" autobuffer="autobuffer"></audio>
					@elseif (substr(substr($msg->content, strpos($msg->content, '+end+')+5), 0, 11) === 'data:@file/')
						<a href="{{ substr($msg->content, strpos($msg->content, '+end+')+5) }}" download="{{ substr($msg->content, 0, strpos($msg->content, '+end+')) }}">
							{{ substr($msg->content, 0, strpos($msg->content, '+end+')) }}
						</a>
					@else
						<span class="text-content">{!! $msg->content !!}</span>
					@endif
				@endif
			</span>
		</p>
		
	</div>
	<div class="func-item">
		<div class="item-container">
			<div class="items">
				@if($msg->deleted_at===null)
					<i class="fal fa-reply" aria-hidden="true" data-route="{{ route('client.msg.reply.request') }}" title="Trả lời"></i>	
				@endif
				@if(auth()->id() === $msg->user_id && $msg->deleted_at===null)
					<i class="fal fa-trash" class="msg-des-modal" data-route="{{ route('client.msg.destroymsgmd') }}" title="Xóa"></i>
				@endif
			</div>
		</div>
	</div>
</li>