		<div class="footer">
			<div class="userInfo">
				<span class="infoRow">
					<span class="infoLabel">Login:</span>
					<span class="infoValue"><?php echo $_SESSION["eng_name"];?>&nbsp;&nbsp;(<?php echo $_SESSION["sUserID"];?>)</span>
				</span>
				<span class="infoRow">
					<span class="infoLabel">Last login:</span>
					<span class="infoValue"><?php echo $_SESSION["last_visit_date"]; ?></span>
				</span>
			</div>
			<div class="copyright">
				<?php echo COPYRIGHT ?> Copyright © 2019
			</div>
		</div>
	</body>
</html>

