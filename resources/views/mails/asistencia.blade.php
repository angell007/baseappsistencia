Hola <i>{{ $correo->nombre }}</i>,
<p>Esto es un correo porque has marcado {{$correo->tipo}}.</p>
 
<p><u>Imagen:</u>
<img src="{{ $correo->imagen }}" style="width:50px;" />
</p>
 
<div>
<p><b>hora:</b>&nbsp;{{ $correo->hora }}</p>
<p><b>ubicacion:</b>&nbsp;{{ $correo->ubicacion }}</p>
</div>
 
<div>
</div>
 
Gracias,
<br/>
<i>Equipo de Talento Humano</i>