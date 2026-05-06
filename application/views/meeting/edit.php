<!DOCTYPE html>
<html>

<head>
    <title><?= $title; ?></title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

<div class="container mt-5">

    <h2>Edit Booking Meeting</h2>

    <?php if ($this->session->flashdata('error')) : ?>
        <div class="alert alert-danger">
            <?= $this->session->flashdata('error'); ?>
        </div>
    <?php endif; ?>

    <div class="card">

        <div class="card-body">

            <form action="<?= base_url('meeting/update/' . $booking->id); ?>" method="POST">

                <div class="mb-3">
                    <label>Meeting Room</label>

                    <select name="room_id" class="form-control" required>

                        <?php foreach ($rooms as $room) : ?>

                            <option
                                value="<?= $room->id; ?>"
                                <?= $booking->room_id == $room->id ? 'selected' : ''; ?>
                            >
                                <?= $room->room_name; ?> - Capacity <?= $room->capacity; ?>
                            </option>

                        <?php endforeach; ?>

                    </select>
                </div>

                <div class="mb-3">
                    <label>Booked By</label>

                    <input
                        type="text"
                        name="booked_by"
                        class="form-control"
                        value="<?= $booking->booked_by; ?>"
                        required
                    >
                </div>

                <div class="mb-3">
                    <label>Meeting Date</label>

                    <input
                        type="date"
                        name="meeting_date"
                        class="form-control"
                        value="<?= $booking->meeting_date; ?>"
                        required
                    >
                </div>

                <div class="row">

                    <div class="col-md-6 mb-3">
                        <label>Start Time</label>

                        <input
                            type="time"
                            name="start_time"
                            class="form-control"
                            value="<?= $booking->start_time; ?>"
                            required
                        >
                    </div>

                    <div class="col-md-6 mb-3">
                        <label>End Time</label>

                        <input
                            type="time"
                            name="end_time"
                            class="form-control"
                            value="<?= $booking->end_time; ?>"
                            required
                        >
                    </div>

                </div>

                <div class="mb-3">
                    <label>Agenda</label>

                    <textarea
                        name="agenda"
                        class="form-control"
                        required><?= $booking->agenda; ?></textarea>
                </div>

                <button type="submit" class="btn btn-primary">
                    Update Booking
                </button>

                <a href="<?= base_url('meeting'); ?>" class="btn btn-secondary">
                    Back
                </a>

            </form>

        </div>

    </div>

</div>

</body>
</html>