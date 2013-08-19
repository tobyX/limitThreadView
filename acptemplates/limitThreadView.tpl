						<fieldset id="limitthreadview">
							<legend>{lang}wbb.acp.board.limitthreadview{/lang}</legend>

							<div class="formElement">
								<div class="formFieldLabel" id="limitThreadViewDiv">
									<label for="limitguestview">{lang}wbb.acp.board.limitthreadview{/lang}</label>
								</div>
								<div class="formField">
									<input type="text" class="inputText" id="limitThreadView" name="limitThreadView" value="{$limitThreadView}" />
								</div>
								<div class="formFieldDesc hidden" id="limitThreadViewHelpMessage">
									{lang}wbb.acp.board.limitthreadview.description{/lang}
								</div>
							</div>
							<script type="text/javascript">//<![CDATA[
							inlineHelp.register('limitThreadView');
							//]]></script>
						</fieldset>