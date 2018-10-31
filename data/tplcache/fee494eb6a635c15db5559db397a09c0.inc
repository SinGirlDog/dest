<span>
					<a href='{dede:field name='typeurl'/}'>
						{dede:field.id runphp='yes'}
						if(@me==9){@me="哎呀对了";}
						else{@me = "唉，错了";}
						{/dede:field.id}
						{dede:field name='typename'/}
					</a>
				</span>