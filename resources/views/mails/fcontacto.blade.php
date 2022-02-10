@component('mail::message')
# Formulario de Contacto


## Nombre


{{$datos['nombre']}}

## Email

_{{$email}}_

## Mensaje

{{$datos['mensaje']}}
@endcomponent