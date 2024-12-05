<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Academic Performance Report</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root {
            --primary-color: #2c3e50;
            --secondary-color: #34495e;
            --accent-color: #3498db;
            --background-light: #f8f9fa;
            --text-color: #2c3e50;
        }

        body {
            font-family: 'Inter', 'Helvetica Neue', Arial, sans-serif;
            background-color: var(--background-light);
            color: var(--text-color);
            line-height: 1.5;
            margin: 0;
        }

        .academic-report {
            max-width: 800px;
            margin: 0 auto;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            padding: 1.5rem;
        }

        .report-header {
            text-align: center;
            margin-bottom: 1rem;
            border-bottom: 2px solid var(--accent-color);
            padding-bottom: 0.5rem;
        }

        .report-header h1 {
            font-size: 1.5rem;
            color: var(--primary-color);
            font-weight: 600;
        }

        .student-info-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 0.5rem;
            margin-bottom: 1rem;
            font-size: 0.9rem;
        }

        .info-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid rgba(0,0,0,0.1);
            padding: 0.3rem 0;
        }

        .info-item label {
            color: var(--secondary-color);
            font-weight: 500;
        }

        .info-item .value {
            font-weight: 600;
            color: var(--primary-color);
            text-align: right;
        }

        .results-table {
            font-size: 0.85rem;
        }

        .results-table thead {
            background-color: var(--accent-color);
            color: white;
        }

        .results-table th, .results-table td {
            padding: 0.5rem;
            text-align: center;
        }

        .status-passed {
            color: #2ecc71;
            font-weight: 600;
        }

        .status-failed {
            color: #e74c3c;
            font-weight: 600;
        }

        .summary-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 0.5rem;
            margin-top: 1rem;
            background-color: var(--background-light);
            padding: 0.5rem;
            border-radius: 6px;
        }

        .summary-section {
            text-align: center;
            font-size: 0.85rem;
        }

        .summary-section .label {
            color: var(--secondary-color);
        }

        .summary-section .value {
            font-size: 1rem;
            font-weight: 600;
            color: var(--primary-color);
        }

        .feedback-section {
            margin-top: 1rem;
            font-size: 0.9rem;
            background-color: rgba(52, 152, 219, 0.05);
            padding: 0.5rem;
            border-left: 4px solid var(--accent-color);
            border-radius: 4px;
        }

        @media print {
            body {
                background-color: white;
                margin: 0;
            }
            .academic-report {
                box-shadow: none;
                padding: 1rem;
            }
        }
    </style>
</head>
<body>
    <div class="academic-report">
        <div class="report-header">
            <h1>Academic Performance Report</h1>
        </div>

        <div class="student-info-grid">
            <div class="info-item">
                <label>Identity Card Number</label>
                <div class="value">{{ $student->ic }}</div>
            </div>
            <div class="info-item">
                <label>Student Name</label>
                <div class="value">{{ $student->name }}</div>
            </div>
            <div class="info-item">
                <label>Gender</label>
                <div class="value">{{ $student->gender }}</div>
            </div>
            <div class="info-item">
                <label>Date of Birth</label>
                <div class="value">{{ $student->dob }}</div>
            </div>
            <div class="info-item">
                <label>Class Name</label>
                <div class="value">{{ $class->name }}</div>
            </div>
            <div class="info-item">
                <label>Examination</label>
                <div class="value">{{ $examination->name }}</div>
            </div>
        </div>

        <div class="results-table">
            <table class="table table-bordered table-sm">
                <thead>
                    <tr>
                        <th>Subject</th>
                        <th>Mark</th>
                        <th>Grade</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($stdResult as $result)
                        <tr>
                            <td>{{ $result->subject->name }}</td>
                            <td>{{ $result->marks }}</td>
                            <td>{{ $result->grade }}</td>
                            <td class="{{ $result->is_passed === 'passed' ? 'status-passed' : 'status-failed' }}">
                                {{ $result->is_passed }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="summary-grid">
            <div class="summary-section">
                <div class="label">Total Marks</div>
                <div class="value">{{ $stdReport->total_mark }}</div>
            </div>
            <div class="summary-section">
                <div class="label">Average Mark</div>
                <div class="value">{{ $stdReport->average_mark }}</div>
            </div>
            <div class="summary-section">
                <div class="label">Pointer</div>
                <div class="value">{{ $stdReport->pointer }}</div>
            </div>
        </div>

        <div class="summary-grid">
            <div class="summary-section">
                <div class="label">Class Position</div>
                <div class="value">9/10</div>
            </div>
            <div class="summary-section">
                <div class="label">Form Position</div>
                <div class="value">18/20</div>
            </div>
            <div class="summary-section">
                <div class="label">Overall Status</div>
                <div class="value {{ $stdReport->is_passed === 'passed' ? 'status-passed' : 'status-failed' }}">
                    {{ $stdReport->is_passed }}
                </div>
            </div>
        </div>

        <div class="feedback-section">
            <h5>Teacher's Feedback</h5>
            <p>{{ $stdReport->feedback }}</p>
        </div>
    </div>
</body>
</html>
