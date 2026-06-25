<?php

include_once 'models/projectclass.php';
$id = $_GET['id'];
$report = Project::getProjectDetails($id);
?>



<h3><?= $report['info']['title']; ?></h3>

<div class="card border-0 shadow-sm mb-4 mt-2">
    <div class="card-body p-4">
        <a href="manage_project" class="btn btn-sm btn-dark">Back</a>
    </div>
</div>


<div class="card border-0 shadow-sm mb-4">
    <div class="card-body p-2">

        <h3 class="mb-1 fw-bold" style="color: var(--pd-ink, #10241F);"><?= $report['info']['title']; ?></h3>
        <p class="text-muted mb-4">Project Overview</p>

        <div class="row g-3">
            <div class="col-md-4">
                <div class="p-3 rounded-3 h-100" style="background:#F3F6F5;">
                    <div class="text-uppercase small text-muted mb-1">
                        <i class="fa-solid fa-building me-1"></i> Client
                    </div>
                    <div class="fw-semibold"><?= $report['info']['client_name']; ?></div>
                    <div class="small text-muted"><?= $report['info']['organization']; ?></div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="p-3 rounded-3 h-100" style="background:#F3F6F5;">
                    <div class="text-uppercase small text-muted mb-1">
                        <i class="fa-solid fa-tags me-1"></i> Category
                    </div>
                    <div class="fw-semibold"><?= $report['info']['category_name']; ?></div>
                    <div class="small text-muted">
                        <i class="fa-regular fa-user me-1"></i> Manager: <?= $report['info']['manager_name']; ?>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <?php
                $budget = $report['info']['budget_cost'];
                $actual = $report['info']['actual_cost'];
                $isOver = $actual > $budget;
                ?>
                <div class="p-3 rounded-3 h-100" style="background:#F3F6F5;">
                    <div class="text-uppercase small text-muted mb-1">
                        <i class="fa-solid fa-sack-dollar me-1"></i> Cost
                    </div>
                    <div class="fw-semibold">Budget: <?= number_format($budget, 2); ?></div>
                    <div class="small">
                        Actual: <?= number_format($actual, 2); ?>
                        <span class="badge <?= $isOver ? 'bg-danger' : 'bg-success'; ?> ms-1">
                            <?= $isOver ? 'Over Budget' : 'On Budget'; ?>
                        </span>
                    </div>
                </div>
            </div>
        </div>

        
        <div class="row g-3 mt-1">
            <div class="col-md-6">
                <div class="p-3 rounded-3 h-100" style="background:#F3F6F5;">
                    <div class="text-uppercase small text-muted mb-1">
                        <i class="fa-regular fa-calendar me-1"></i> Expected Timeline
                    </div>
                    <div class="fw-semibold">
                        <?= date('M d, Y', strtotime($report['info']['expected_starting_time'])); ?>
                        <i class="fa-solid fa-arrow-right mx-1 text-muted small"></i>

                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <?php
                $hasActualStart = !empty($report['info']['actual_starting_time']);
                $hasActualEnd = !empty($report['info']['actual_ending_time']);
                $isDelayed = $hasActualEnd && strtotime($report['info']['actual_ending_time']) > strtotime($report['info']['expected_ending_time']);
                ?>
                <div class="p-3 rounded-3 h-100" style="background:#F3F6F5;">
                    <div class="text-uppercase small text-muted mb-1">
                        <i class="fa-solid fa-calendar-check me-1"></i> Actual Timeline
                    </div>
                    <div class="fw-semibold">
                        <?php if ($hasActualStart): ?>

                            <i class="fa-solid fa-arrow-right mx-1 text-muted small"></i>
                            <?= $hasActualEnd ? date('M d, Y', strtotime($report['info']['actual_ending_time'])) : 'In Progress'; ?>
                            <?php if ($hasActualEnd): ?>
                                <span class="badge <?= $isDelayed ? 'bg-danger' : 'bg-success'; ?> ms-1">
                                    <?= $isDelayed ? 'Delayed' : 'On Time'; ?>
                                </span>
                            <?php endif; ?>
                        <?php else: ?>
                            <span class="text-muted fw-normal">Not started yet</span>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>




<!-- Phases -->
<div class="card border-0 shadow-sm mb-4">
  <div class="card-header bg-white border-0 pt-4 px-4">
    <h5 class="mb-0 fw-bold"><i class="fa-solid fa-layer-group me-2 text-success"></i>Phases</h5>
  </div>
  <div class="card-body px-4 pb-4 pt-0">
    <div class="table-responsive">
      <table class="table table-hover align-middle mb-0">
        <thead>
          <tr class="text-uppercase small text-muted">
            <th>Phase</th>
            <th>Allocated Cost</th>
            <th>Actual Cost</th>
            <th>Expected Time</th>
            <th>Actual Time</th>
            <th>Status</th>
          </tr>
        </thead>
        <tbody>
          <?php if (empty($report['phases'])): ?>
            <tr>
              <td colspan="6" class="text-center text-muted py-4">No phase data added for this project yet.</td>
            </tr>
          <?php else: ?>
            <?php foreach ($report['phases'] as $p): ?>
              <?php $over = $p['actual_cost'] > $p['allocated_cost']; ?>
              <tr>
                <td class="fw-semibold"><?= $p['phase_title']; ?></td>
                <td><?= number_format($p['allocated_cost'], 2); ?></td>
                <td><?= number_format($p['actual_cost'], 2); ?></td>
                <td><?= $p['expected_time']; ?> </td>
                <td><?= $p['actual_time']; ?> </td>
                <td>
                  <span class="badge <?= $over ? 'bg-danger' : 'bg-success'; ?>">
                    <?= $over ? 'Over Budget' : 'On Budget'; ?>
                  </span>
                </td>
              </tr>
            <?php endforeach; ?>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<!-- Team -->
<div class="card border-0 shadow-sm mb-4">
    <div class="card-header bg-white border-0 pt-4 px-4">
        <h5 class="mb-0 fw-bold"><i class="fa-solid fa-users me-2 text-success"></i>Team</h5>
    </div>
    <div class="card-body px-4 pb-4 pt-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead>
                    <tr class="text-uppercase small text-muted">
                        <th>Member</th>
                        <th>Role</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($report['team'])): ?>
                        <tr>
                            <td colspan="2" class="text-center text-muted py-4">No team members assigned yet.</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($report['team'] as $t): ?>
                            <tr>
                                <td class="d-flex align-items-center gap-2">
                                    <span class="d-inline-flex align-items-center justify-content-center rounded-circle bg-light text-success fw-semibold"
                                        style="width:32px;height:32px;font-size:.8rem;">
                                        <?= strtoupper(substr($t['member_name'], 0, 1)); ?>
                                    </span>
                                    <?= $t['member_name']; ?>
                                </td>
                                <td><span class="badge bg-light text-dark border"><?= $t['role_name']; ?></span></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Tasks -->
<div class="card border-0 shadow-sm mb-4">
    <div class="card-header bg-white border-0 pt-4 px-4">
        <h5 class="mb-0 fw-bold"><i class="fa-solid fa-list-check me-2 text-success"></i>Tasks</h5>
    </div>
    <div class="card-body px-4 pb-4 pt-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead>
                    <tr class="text-uppercase small text-muted">
                        <th>Task</th>
                        <th>Phase</th>
                        <th>Team</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($report['tasks'])): ?>
                        <tr>
                            <td colspan="3" class="text-center text-muted py-4">No tasks created for this project yet.</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($report['tasks'] as $tk): ?>
                            <tr>
                                <td class="fw-semibold"><?= $tk['task_title']; ?></td>
                                <td><span class="badge bg-light text-dark border"><?= $tk['phase_title']; ?></span></td>
                                <td><?= $tk['team_name']; ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>