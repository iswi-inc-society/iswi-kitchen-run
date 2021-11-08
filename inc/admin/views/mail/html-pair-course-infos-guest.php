<?php

use KitchenRun\Inc\Common\Model\Team;
use League\Plates\Template\Template;

/**
 * View to render guest informations for email
 *
 * @since   1.0.0
 *
 * @author  Niklas Loos <niklas.loos@live.com>
 *
 * @var       Template  $this           Object of the class where this view is included.
 * @var       Team      $team           Cooking Team
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
                        <h4><?= $course_name ?>: <b><?= $start_time ?> to <?= $end_time ?></b> (Guest Team) </h4>
						<?php if ($course == 0): //Appetizer ?>
							<p>Always a great dinner starts with a great Appetizer. So to have a great evening, you are set with the team "<?= $team->getName() ?>" and your food preferences are given to them. Given below is the address of your hosts. </p>
						<?php elseif ($course == 1): // Main Course ?>
							<p>The soul of any dinner is this, lets have your taste buds experience it. So, you are set with the team "<?= $team->getName() ?>" and your food preferences are given to them. Given below is the address of your hosts.</p>
						<?php elseif ($course == 2): // Dessert ?>
							<p>Like Moon for the Night, the Dessert is for Dinner. You are set with the team "<?= $team->getName() ?>" and your food preferences are given to them. Given below is the address of your hosts.</p>
						<?php endif; ?>
                        
                            <!--- CALLOUT -->
						<table class="callout large-12">
							<tr>
								<th class="callout-inner secondary large-12">

									<table class="desc">
										<tr>
											<td>Team:</td><td><?= $team->getName() ?></td>
										</tr>

                                        <tr>
                                            <td>Name:</td><td><?php echo $team->getMember1(); if ($team->getMember2() != '') echo ' and '.$team->getMember2(); ?></td>
                                        </tr>

										<tr>
											<td>Contact:</td><td><?= $team->getEmail() ?></td>
										</tr>

										<tr>
											<td>Address:</td><td><?= $team->getAddress() ?></td>
										</tr>

										<tr>
											<td>City:</td><td><?= $team->getCity() ?></td>
										</tr>

									</table>
								</th>
								<th class="expander"></th>
							</tr>
						</table>


						<?php if ($team->getEvent()->isOnline()): ?>
                        <p><b>Meeting Link:</b>
                            <?php if ($team->getLink() != null): ?>
                                <a href="<?= $team->getLink()?>">Here</a>
                            <?php else: ?>
                                -
                            <?php endif; ?>
                        </p>
						<?php endif; ?>

						<p>Additional description of their address: <?php echo ($team->getFindPlace() != '') ?  $team->getFindPlace() :  '-' ?></p>
					</th>
				</tr>
			</table>
		</th>
	</tr>
	</tbody>
</table>
