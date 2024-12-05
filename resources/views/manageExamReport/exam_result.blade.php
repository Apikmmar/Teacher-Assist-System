<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Academic Performance Report</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.5/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        :root {
            --primary-color: #1e3a8a;
            --secondary-color: #4f46e5;
            --accent-color: #0ea5e9;
            --background-light: #f9fafb;
            --text-dark: #1e293b;
            --text-light: #64748b;
            --light-shadow: rgba(0, 0, 0, 0.05);
        }
    
        body {
            font-family: 'Poppins', sans-serif;
            background-color: var(--background-light);
            margin: 0;
            padding: 0;
        }
    
        .academic-report {
            max-width: 210mm; /* A4 width */
            background: white;
            margin: 1rem auto;
            padding: 1.5rem;
            border-radius: 10px;
            box-shadow: 0 8px 20px var(--light-shadow);
        }
    
        .report-header {
            text-align: center;
            margin-bottom: 1.5rem;
        }
    
        .report-header h1 {
            background: linear-gradient(90deg, var(--primary-color), var(--accent-color));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            font-size: 1.8rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }
    
        .divider {
            width: 60%;
            height: 4px;
            margin: 0 auto 1.5rem;
            background: var(--accent-color);
            border-radius: 50px;
        }
    
        .student-info-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 1rem;
            padding: 1rem;
            border-radius: 8px;
            background: var(--background-light);
            border: 1px solid var(--light-shadow);
            margin-bottom: 1.5rem;
        }
    
        .info-item label {
            font-size: 0.85rem;
            font-weight: 500;
            color: var(--text-light);
        }
    
        .info-item .value {
            font-size: 0.95rem;
            font-weight: 600;
            color: var(--text-dark);
        }
    
        .results-table {
            margin: 1.5rem 0;
        }
    
        .results-table th {
            background: var(--secondary-color);
            color: white;
            font-size: 0.9rem;
            text-align: center;
        }
    
        .results-table td {
            font-size: 0.85rem;
            text-align: center;
            padding: 0.75rem;
        }
    
        .badge {
            font-size: 0.75rem;
            padding: 0.25rem 0.5rem;
            border-radius: 10px;
        }
    
        .badge-success {
            background: #10b981;
            color: white;
        }
    
        .badge-danger {
            background: #ef4444;
            color: white;
        }
    
        .summary-grid {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-top: 1rem;
        }
    
        .summary-section {
            text-align: center;
            width: 100%;
            height: 200px
            padding: 0.3rem;
            border-radius: 10px;
            background: rgba(14, 165, 233, 0.1);
            box-shadow: 0 2px 8px var(--light-shadow);
        }
    
        .summary-section h4 {
            font-size: 0.75rem;
            font-weight: 500;
            color: var(--text-light);
            margin-bottom: 0.25rem;
        }
    
        .summary-section p {
            font-size: 0.9rem;
            font-weight: 600;
            color: var(--text-dark);
        }
    
        .feedback-section {
            margin-top: 2rem;
            padding: 1rem;
            border-radius: 8px;
            background: rgba(31, 41, 55, 0.05);
        }
    
        .feedback-section h5 {
            font-weight: 600;
            font-size: 1rem;
            color: var(--primary-color);
            margin-bottom: 0.5rem;
        }
    
        .feedback-section p {
            font-size: 0.9rem;
            color: var(--text-light);
        }
    
        @media print {
            .academic-report {
                box-shadow: none;
                margin: 0;
                padding: 1rem;
            }
    
            @page {
                size: A4 portrait;
                margin: 1cm;
            }
    
            img {
                display: block !important;
            }
        }
    </style>    
</head>
<body>
    <div class="container">
        <div class="academic-report">
            <div class="report-header">
                <h1>Academic Performance Report</h1>
                <div class="divider"></div>
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
                <table class="table table-striped table-hover" style="min-width: 400px">
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
                                <td>
                                    <span class="badge {{ $result->is_passed === 'passed' ? 'badge-success' : 'badge-danger' }}">
                                        {{ $result->is_passed }}
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="summary-grid d-flex justify-content-center">
                <div class="summary-section">
                    <h4>Total Marks</h4>
                    <p>{{ $stdReport->total_mark }}</p>
                </div>
                <div class="summary-section">
                    <h4>Average Mark</h4>
                    <p>{{ $stdReport->average_mark }}</p>
                </div>
                <div class="summary-section">
                    <h4>Pointer</h4>
                    <p>{{ $stdReport->pointer }}</p>
                </div>
            </div>
            

            <div class="feedback-section">
                <h5>Teacher's Feedback</h5>
                <p>{{ $stdReport->feedback }}</p>
            </div>
        </div>
    </div>
</body>
</html>
