$header
<article>
  <header>
    <h2>
      <img src="images/Froxlor/icons/email_add.png" alt="{$lng['emails']['quota_edit']}" />&nbsp;
      {$lng['emails']['quota_edit']}
    </h2>
  </header>
  
  <section class="fullform bradiusodd">

      <form action="$filename" method="post" enctype="application/x-www-form-urlencoded">
        <fieldset>
          <legend>Froxlor&nbsp;-&nbsp;{$lng['emails']['quota_edit']}</legend>

          <table class="formtable">
            {$quota_edit}
          </table>

          <p style="display: none;">
            <input type="hidden" name="s" value="$s" />
            <input type="hidden" name="page" value="$page" />
            <input type="hidden" name="action" value="$action" />
            <input type="hidden" name="send" value="send" />
          </p>
        </fieldset>
      </form>
  </section>
</article>
$footer