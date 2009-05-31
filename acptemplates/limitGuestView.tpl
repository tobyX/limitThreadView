						<fieldset id="limitguestview">
							<legend>{lang}wbb.acp.board.limitguestview{/lang}</legend>
							
							<div class="formElement">
								<div class="formFieldLabel" id="limitGuestViewDiv">
									<label for="limitguestview">{lang}wbb.acp.board.limitguestview{/lang}</label>
								</div>
								<div class="formField">
									<input type="text" class="inputText" id="limitGuestView" name="limitGuestView" value="{$limitGuestView}" />
								</div>
								<div class="formFieldDesc hidden" id="limitGuestViewHelpMessage">
									{lang}wbb.acp.board.limitguestview.description{/lang}
								</div>
							</div>
							<script type="text/javascript">//<![CDATA[
							inlineHelp.register('limitGuestView');
							//]]></script>
						</fieldset>