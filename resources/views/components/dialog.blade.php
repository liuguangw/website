<table class="dialog{{ $extClass }}" cellpadding="0" cellspacing="0" style="display: none;">
    <tr>
        <td class="dialog-border b-topleft"></td>
        <td class="dialog-border b-top"></td>
        <td class="dialog-border b-topright"></td>
    </tr>
    <tr>
        <td class="dialog-border b-left"></td>
        <td>{{ $slot }}</td>
        <td class="dialog-border b-right"></td>
    </tr>
    <tr>
        <td class="dialog-border b-bottomleft"></td>
        <td class="dialog-border b-bottom"></td>
        <td class="dialog-border b-bottomright"></td>
    </tr>
</table>
