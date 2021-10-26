<?php

use KitchenRun\Inc\Common\Model\Team;
use League\Plates\Template\Template;

/**
 * View to render cook informations for email
 *
 * @since   1.0.0
 *
 * @author  Niklas Loos <niklas.loos@live.com>
 *
 * @var       Template  $this           Object of the class where this view is included.
 * @var       Team      $team1          Guest Team 1
 * @var       string    $food_pref1     Food preferences of team 1
 * @var       Team      $team2          Guest Team 2
 * @var       string    $food_pref2     Food preferences of team 2
 * @var       int       $course         Course number
 * @var       string    $date           String of the Event Date
 * @var       string    $start_time     String of the time for the course
 * @var       string    $end_time       String of the end time for the course
 */

$course_name='';

switch($course) {
	case 0:
		$course_name = 'Appetizer';
		break;
	case 1:
		$course_name = 'Main Course';
		break;
	case 2:
		$course_name = 'Dessert';
		break;
}
?>

<table class="row">
	<tbody>
	<tr>

		<th class="small-12 large-12 columns first last">
			<table>
				<tr>
					<th>
						<h4><?= $course_name ?>: <b><?= $start_time ?> to <?= $end_time ?></b> (Cooking Team)</h4>
                        <p>In this course you are the Cooking Team. Please consider the food preferences and requests of your guests, especially allergies and co. The other Teams will come to your home and pick up the food. Have everything ready at <?= $start_time ?>. Here are all information you need:</p>

							<!--- CALLOUT -->
						<table class="callout large-12">
							<tr>
								<th class="callout-inner secondary large-12">

									<table class="desc">
										<tr>
											<td>Team 1:</td><td><?= $team1->getName() ?></td>
										</tr>

										<tr>
											<td>Contact:</td><td><?= $team1->getEmail() ?></td>
										</tr>

										<tr>
											<td>Food Preferences:</td><td><?= $food_pref1 ?></td>
										</tr>

										<tr>
											<td>Food Request:</td><td><?php echo ($team1->getFoodRequest() != '') ?  $team1->getFoodRequest() :  '-' ?></td>
										</tr>

									</table>
								</th>
								<th class="expander"></th>
							</tr>
						</table>


						<!--- CALLOUT -->
						<table class="callout large-12">
							<tr>
								<th class="callout-inner secondary large-12">

									<table class="desc">
										<tr>
											<td>Team 2:</td><td><?= $team2->getName() ?></td>
										</tr>

										<tr>
											<td>Contact:</td><td><?= $team2->getEmail() ?></td>
										</tr>

										<tr>
											<td>Food Preferences:</td><td><?= $food_pref2 ?></td>
										</tr>

										<tr>
											<td>Food Request:</td><td><?php echo ($team2->getFoodRequest() != '') ?  $team2->getFoodRequest() :  '-' ?></td>
										</tr>


									</table>
								</th>
								<th class="expander"></th>
							</tr>
						</table>

						<?php if ($cook->getEvent()->isOnline()): ?>
                        <p><b>Meeting Link:</b>
							<?php if ($cook->getLink() != null): ?>
                                <a href="<?= $cook->getLink()?>">Here</a>
							<?php else: ?>
                                -
							<?php endif; ?>
                        </p>
						<?php endif; ?>
					</th>
				</tr>
			</table>
		</th>
	</tr>
	</tbody>
</table>
