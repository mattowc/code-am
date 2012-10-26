<?php
/**
 * Footer for the blog template
 *
 * @author Jonathon McDonald <jon@onewebcentric.com>
 */
?>
<?php if(!wpv_is_reduced_response()): ?>
			</div>
		</div>
	</div>
</div>

<?php endif;

if(!wpv_is_reduced_response()) {
	get_footer();
} else {
	wpv_reduced_footer();
}
