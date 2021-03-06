<div class="note-container">
  <div class="name_note"><?php echo $data['name']; ?></div>
  <div class="mdl-tabs mdl-js-tabs mdl-js-ripple-effect">
    <div class="mdl-tabs__tab-bar">
        <a href="#text-tab" class="mdl-tabs__tab is-active note-text-title">Texto plano</a>
        <a href="#html-tab" class="mdl-tabs__tab note-html-title">Editor HTML</a>
    </div>
    <div class="mdl-tabs__panel is-active note-text" id="text-tab">
      <form action="<?php echo URL; ?>Public/note/<?php echo $data['name']; ?>" method="POST">
        <textarea class="note-txt-plain" name="text_note" id="text_note" rows="23" autofocus><?php echo $data['text']->plain_text; ?></textarea>
        <button type="submit" class="mdl-button mdl-js-button mdl-button--primary" name="text">Guardar</button>
        <button class="mdl-button mdl-js-button mdl-button--icon"><i class="material-icons">lock</i></button>
        <button class="mdl-button mdl-js-button mdl-button--icon"><i class="material-icons">lock_open</i></button>
      </form>
    </div>
    <div class="mdl-tabs__panel note-html" id="html-tab">
      <form action="<?php echo URL; ?>Public/note/<?php echo $data['name']; ?>" method="POST">
        <textarea id="note-txt-html" name="html_note" id="html_note" autofocus><?php echo $data['html']->html; ?></textarea>
        <script>CKEDITOR.replace('note-txt-html');</script>
        <button type="submit" class="mdl-button mdl-js-button mdl-button--primary" name="html">Guardar</button>
      </form>
      <a class="mdl-button" href="<?php echo URL; ?>Public/viewNote/<?php echo $data['name']; ?>">Ver como página web</a>
    </div>
  </div>
</div>
