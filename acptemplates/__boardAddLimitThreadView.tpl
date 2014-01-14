<dl{if $errorField == 'limitThreadView'} class="formError"{/if}>
	<dt>
		<label for="limitThreadView">{lang}wbb.acp.board.limitthreadview{/lang}</label>
	</dt>
	<dd>
		<input type="number" id="limitThreadView" name="limitThreadView" value="{if $limitThreadView}{@$limitThreadView}{/if}" class="tiny" min="1" />
		<small>{lang}wbb.acp.board.limitthreadview.description{/lang}</small>
		{if $errorField == 'limitThreadView'}
			<small class="innerError">
				{lang}wbb.acp.board.limitthreadview.error.{@$errorType}{/lang}
			</small>
		{/if}

	</dd>
</dl>