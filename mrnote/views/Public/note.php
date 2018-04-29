<div class="note-container">
  <div class="mdl-tabs mdl-js-tabs mdl-js-ripple-effect">
    <div class="mdl-tabs__tab-bar">
        <a href="#text-tab" class="mdl-tabs__tab is-active note-text-title">Texto plano</a>
        <a href="#html-tab" class="mdl-tabs__tab note-html-title">Editor HTML</a>
    </div>
    <div class="mdl-tabs__panel is-active note-text" id="text-tab">
      <form method="post">
        <textarea class="note-txt-plain" name="note" autofocus></textarea>
        <button class="mdl-button mdl-js-button mdl-button--primary">Guardar</button>
      </form>
    </div>
    <div class="mdl-tabs__panel note-html" id="html-tab">
      <form method="post">
        <textarea id="note-txt-html" name="html-note" autofocus></textarea>
        <script>CKEDITOR.replace( 'note-txt-html' );</script>
        <button class="mdl-button mdl-js-button mdl-button--primary">Guardar</button>
      </form>

    </div>
  </div>
</div>
