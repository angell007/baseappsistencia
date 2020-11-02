Hola <i>{{ $correo->nombre }}</i>,
<p>Esto es un correo porque has marcado {{$correo->tipo}}.</p>
 
<p><u>Imagen:</u>
<img src="{{ $correo->imagen }}" />
</p>
 
<div>
<p><b>hora:</b>&nbsp;{{ $correo->hora }}</p>
<p><b>ubicacion:</b>&nbsp;{{ $correo->ubicacion }}</p>
</div>
 
<p><u>Values passed by With method:</u></p>
 
<div>
</div>
 
Gracias,
<br/>
<i>Equipo de Talento Humano</i>