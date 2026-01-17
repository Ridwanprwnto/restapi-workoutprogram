-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 03, 2024 at 04:17 PM
-- Server version: 10.4.25-MariaDB
-- PHP Version: 7.4.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `workout`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_bmi`
--

CREATE TABLE `tbl_bmi` (
  `id_bmi` int(2) NOT NULL,
  `code_bmi` varchar(3) NOT NULL,
  `category_bmi` varchar(52) NOT NULL,
  `nilai_awal_bmi` varchar(9) DEFAULT NULL,
  `nilai_akhir_bmi` varchar(9) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_bmi`
--

INSERT INTO `tbl_bmi` (`id_bmi`, `code_bmi`, `category_bmi`, `nilai_awal_bmi`, `nilai_akhir_bmi`) VALUES
(20, 'C01', 'Underweight', '0', '18,4'),
(21, 'C02', 'Normal', '18,5', '24,9'),
(22, 'C03', 'Overweight', '25', '29,9'),
(23, 'C04', 'Obese I', '30', '34,9'),
(24, 'C05', 'Obese II', '35', '39,9'),
(25, 'C06', 'Obese III', '40', '49,9');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_bodypart`
--

CREATE TABLE `tbl_bodypart` (
  `id_bodypart` int(9) NOT NULL,
  `name_bodypart` char(52) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_bodypart`
--

INSERT INTO `tbl_bodypart` (`id_bodypart`, `name_bodypart`) VALUES
(1, 'Trapezius'),
(2, 'Shoulder'),
(3, 'Chest'),
(4, 'Back'),
(5, 'Biceps'),
(6, 'Core'),
(7, 'Triceps'),
(8, 'Forearms'),
(9, 'Calf'),
(10, 'Glutes'),
(11, 'Leg'),
(12, 'Heart');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_exercise`
--

CREATE TABLE `tbl_exercise` (
  `id_exercise` int(9) NOT NULL,
  `id_type_workout` int(9) NOT NULL,
  `id_bodypart` int(9) NOT NULL,
  `name_workout` char(52) NOT NULL,
  `met_exercise` int(9) NOT NULL,
  `animation_exercise_man` varchar(52) DEFAULT NULL,
  `animation_exercise_woman` varchar(52) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_exercise`
--

INSERT INTO `tbl_exercise` (`id_exercise`, `id_type_workout`, `id_bodypart`, `name_workout`, `met_exercise`, `animation_exercise_man`, `animation_exercise_woman`) VALUES
(1, 1, 1, 'Barbell Shrug', 5, 'BarbellShrug.gif', NULL),
(2, 1, 1, 'Dumbbell Shrug', 3, 'DumbbellShrug.gif', NULL),
(3, 1, 1, 'Smith Machine Barbell Shrug', 7, 'SmithMachineBarbellShrug.gif', NULL),
(4, 1, 1, 'Cable Shrug', 3, 'CableShrug.gif', NULL),
(5, 1, 1, 'Prone Incline Shrug', 5, 'ProneInclineShrug.gif', NULL),
(6, 1, 1, 'Dumbbell Upright Row', 3, 'DumbbellUprightRow.gif', NULL),
(7, 1, 2, 'Cable Lateral Raise', 3, 'CableLateralRaise.gif', NULL),
(8, 1, 2, 'Dumbbell Lateral Raise', 3, 'DumbbellLateralRaise.gif', NULL),
(9, 1, 2, 'Dumbbell Shoulder Press', 3, 'DumbbellShoulderPress.gif', NULL),
(10, 1, 2, 'Smith Machine Shoulder Press', 5, 'SmithMachineShoulderPress.gif', NULL),
(11, 1, 2, 'Barbell Military Press', 7, 'BarbellMilitaryPress.gif', NULL),
(12, 1, 2, 'Cable Upright Row', 3, 'CableUprightRow.gif', NULL),
(13, 1, 2, 'Machine Lateral Raise', 3, 'MachineLateralRaise.gif', NULL),
(14, 1, 2, 'Smith Machine Upright Row', 7, 'SmithMachineUprightRow.gif', NULL),
(15, 1, 2, 'Weight Plate Front Raise', 3, 'WeightPlateFrontRaise.gif', NULL),
(16, 1, 2, 'Dumbbell Cuban Press', 5, 'DumbbellCubanPress.gif', NULL),
(17, 1, 2, 'Standing Alternating Dumbbell Shoulder Press', 3, NULL, 'StandingAlternatingDumbbellShoulderPress.gif'),
(18, 1, 2, 'Incline Dumbbell Reverse Fly', 5, 'InclineDumbbellReverseFly.gif', NULL),
(19, 1, 2, 'Alternate Dumbbell Lateral Raise', 3, 'AlternateDumbbellLateralRaise.gif', NULL),
(20, 1, 2, 'Barbell Upright Row', 5, 'BarbellUprightRow.gif', NULL),
(21, 1, 2, 'Face Pull With Resistance Band', 3, NULL, 'FacePullWithResistanceBand.gif'),
(22, 1, 2, 'Seated Barbell Shoulder Press', 7, 'SeatedBarbellShoulderPress.gif', NULL),
(23, 1, 3, 'Dumbbell Chest Fly', 3, 'DumbbellChestFly.gif', NULL),
(24, 1, 3, 'Incline Dumbbell Press', 5, 'InclineDumbbellPress.gif', NULL),
(25, 1, 3, 'Machine Incline Chest Press', 3, NULL, 'MachineInclineChestPress.gif'),
(26, 1, 3, 'Pec Deck Fly', 3, 'PecDeckFly.gif', 'PecDeckFly.gif'),
(27, 1, 3, 'Chest Dips', 5, 'ChestDips.gif', NULL),
(28, 1, 3, 'Clap Push-Up', 5, 'ClapPush-Up.gif', NULL),
(29, 1, 3, 'Dips Between Chairs', 5, 'DipsBetweenChairs.gif', NULL),
(30, 1, 3, 'Smith Machine Decline Bench Press', 5, 'SmithMachineDeclineBenchPress.gif', NULL),
(31, 1, 3, 'Decline Barbell Bench Press', 7, 'DeclineBarbellBenchPress.gif', NULL),
(32, 1, 3, 'Decline Cable Fly', 5, NULL, 'DeclineCableFly.gif'),
(33, 1, 3, 'Incline Push-up', 3, 'InclinePush-up.gif', NULL),
(34, 1, 3, 'Incline Cable Bench Press', 5, 'InclineCableBenchPress.gif', NULL),
(35, 1, 3, 'Standing Cable Chest Flyes', 5, 'StandingCableChestFlyes.gif', NULL),
(36, 1, 3, 'Dumbbell Pullover', 5, 'DumbbellPullover.gif', NULL),
(37, 1, 3, 'Machine Fly', 3, 'MachineFly.gif', NULL),
(38, 1, 4, 'Back Extensions', 3, 'BackExtensions.gif', NULL),
(39, 1, 4, 'Barbell Row', 5, 'BarbellRow.gif', NULL),
(40, 1, 4, 'Bent Over Barbell Rows', 7, 'BentOverBarbellRows.gif', NULL),
(41, 1, 4, 'Bent Over Dumbell Rows', 5, 'BentOverDumbellRows.gif', 'BentOverDumbellRows.gif'),
(42, 1, 4, 'Kettlebell Bent-over Rows', 3, 'KettlebellBent-overRows.gif', NULL),
(43, 1, 4, 'Pull-up', 5, 'Pull-up.gif', NULL),
(44, 1, 4, 'Seated Machine Row', 3, 'SeatedMachineRow.gif', NULL),
(45, 1, 4, 'Cable Rear Pulldown', 5, 'CableRearPulldown.gif', NULL),
(46, 1, 4, 'Seated Cable Row', 3, 'SeatedCableRow.gif', NULL),
(47, 1, 4, 'Reverse Lat-Pulldown', 5, 'ReverseLat-Pulldown.gif', NULL),
(48, 1, 4, 'Reverse Grip Barbell Row', 7, 'ReverseGripBarbellRow.gif', NULL),
(49, 1, 4, 'Barbell Decline Bent Arm Pullover', 7, 'BarbellDeclineBentArmPullover.gif', NULL),
(50, 1, 4, 'Barbell Pendlay Row', 7, 'BarbellPendlayRow.gif', NULL),
(51, 1, 4, 'Deadlift', 7, 'Deadlift.gif', NULL),
(52, 1, 4, 'Kneeling Cable High Row', 3, NULL, 'KneelingCableHighRow.gif'),
(53, 1, 5, 'Barbell Reverse Curl', 5, 'BarbellReverseCurl.gif', NULL),
(54, 1, 5, 'Cable Preacher Curl', 3, 'CablePreacherCurl.gif', NULL),
(55, 1, 5, 'Close Grip Barbell Curl', 5, 'CloseGripBarbellCurl.gif', NULL),
(56, 1, 5, 'Cross-Body Hammer Curl', 3, NULL, 'Cross-BodyHammerCurl.gif'),
(57, 1, 5, 'Dumbell Concentration Curls', 3, 'DumbellConcentrationCurls.gif', NULL),
(58, 1, 5, 'Ez Bar Preacher Curl Woman', 3, 'EzBarPreacherCurlWoman.gif', NULL),
(59, 1, 5, 'Ez Bar Preacher Curl', 5, 'EzBarPreacherCurl.gif', 'EzBarPreacherCurl.gif'),
(60, 1, 5, 'Flexor Incline Dumbbell Curl', 5, NULL, 'FlexorInclineDumbbellCurl.gif'),
(61, 1, 5, 'Dumbbell Incline Hammer Curl', 5, NULL, 'DumbbellInclineHammerCurl.gif'),
(62, 1, 5, 'Machine Preacher Curl', 3, 'MachinePreacherCurl.gif', NULL),
(63, 1, 5, 'Reverse Cable Curl', 3, 'ReverseCableCurl.gif', NULL),
(64, 1, 5, 'Single-Arm Ez Bar Reverse Curl', 5, 'Single-ArmEzBarReverseCurl.gif', NULL),
(65, 1, 5, 'Standing Dumbbell Bicep Curl', 5, 'StandingDumbbellBicepCurl.gif', NULL),
(66, 1, 5, 'Cable Hammer Curl', 3, 'CableHammerCurl.gif', NULL),
(67, 1, 5, 'Dumbbell Preacher Curl', 3, 'DumbbellPreacherCurl.gif', NULL),
(68, 1, 6, 'Bicycle Crunch', 5, 'BicycleCrunch.gif', NULL),
(69, 1, 6, 'Hanging Knee Raises', 5, 'HangingKneeRaises.gif', NULL),
(70, 1, 6, 'High to Low Pulley Rotation', 3, NULL, 'HightoLowPulleyRotation.gif'),
(71, 1, 6, 'Low to High Pulley Rotation', 3, NULL, 'LowtoHighPulleyRotation.gif'),
(72, 1, 6, 'Standing Cable Crunch', 3, 'StandingCableCrunch.gif', NULL),
(73, 1, 6, 'Toes to Bar', 7, 'ToestoBar.gif', NULL),
(74, 1, 6, 'Weighted Sit Ups', 5, 'WeightedSitUps.gif', NULL),
(75, 1, 6, 'Twisting Hyperextension', 3, NULL, 'TwistingHyperextension.gif'),
(76, 1, 6, 'Seated Twist Machine', 3, 'SeatedTwistMachine.gif', NULL),
(77, 1, 6, 'Medicine Dumbbell Crunch', 5, 'MedicineDumbbellCrunch.gif', NULL),
(78, 1, 7, 'Barbell Skull Crusher', 7, 'BarbellSkullCrusher.gif', NULL),
(79, 1, 7, 'Diamond Push-ups', 3, 'DiamondPush-ups.gif', NULL),
(80, 1, 7, 'Incline Tricep Barbell Extension', 7, 'InclineTricepBarbellExtension.gif', NULL),
(81, 1, 7, 'Incline Tricep Cable Extension', 3, 'InclineTricepCableExtension.gif', NULL),
(82, 1, 7, 'Incline Tricep Dumbell Extension', 5, 'InclineTricepDumbellExtension.gif', NULL),
(83, 1, 7, 'Machine Tricep Dip', 3, 'MachineTricepDip.gif', NULL),
(84, 1, 7, 'Overhead Cable Tricep', 3, 'OverheadCableTricep.gif', NULL),
(85, 1, 7, 'Single-Arms Overhead Cable Tricep', 3, 'Single-ArmsOverheadCableTricep.gif', NULL),
(86, 1, 7, 'Push-down', 3, 'Push-down.gif', NULL),
(87, 1, 7, 'Cable Tricep Kickback', 3, 'CableTricepKickback.gif', 'CableTricepKickback.gif'),
(88, 1, 7, 'Seated Dumbbell Triceps Extension', 3, 'SeatedDumbbellTricepsExtension.gif', NULL),
(89, 1, 7, 'Standing Dumbbell Triceps Extension', 5, 'StandingDumbbellTricepsExtension.gif', NULL),
(90, 1, 7, 'Single-Arms Overhead Dumbbell Tricep', 3, NULL, 'Single-ArmsOverheadDumbbellTricep.gif'),
(91, 1, 7, 'Seated Ez-Bar Overhead Triceps Extension', 5, 'SeatedEz-BarOverheadTricepsExtension.gif', NULL),
(92, 1, 7, 'Dumbbell Kickback', 5, 'DumbbellKickback.gif', NULL),
(93, 1, 8, 'Wrist Roller', 3, 'WristRoller.gif', NULL),
(94, 1, 8, 'Standing Behind The-Back Barbell Curl', 5, 'StandingBehindThe-BackBarbellCurl.gif', NULL),
(95, 1, 8, 'Barbell Wrist Curl', 5, 'BarbellWristCurl.gif', NULL),
(96, 1, 8, 'Dumbbell Reverse Wrist Curl', 5, 'DumbbellReverseWristCurl.gif', NULL),
(97, 1, 8, 'Cable Reverse Wrist Curl', 3, 'CableReverseWristCurl.gif', NULL),
(98, 1, 8, 'Barbell Reverse Wrist Curl', 5, 'BarbellReverseWristCurl.gif', NULL),
(99, 1, 9, 'Bodyweight Calf Raises', 3, NULL, 'BodyweightCalfRaises.gif'),
(100, 1, 9, 'Dumbbell Calf Raises', 5, 'DumbbellCalfRaises.gif', NULL),
(101, 1, 9, 'Seated Dumbbell Calf Raise', 3, 'SeatedDumbbellCalfRaise.gif', NULL),
(102, 1, 9, 'Single-Leg Bodyweight Calf Raises', 3, 'Single-LegBodyweightCalfRaises.gif', NULL),
(103, 1, 9, 'Standing Calf Raise', 3, NULL, 'StandingCalfRaise.gif'),
(104, 1, 9, 'Leg Press Calf Raise', 3, 'LegPressCalfRaise.gif', NULL),
(105, 1, 10, 'Cable Pull Through', 3, NULL, 'CablePullThrough.gif'),
(106, 1, 10, 'Hip Thrusts', 5, NULL, 'HipThrusts.gif'),
(107, 1, 11, 'Leg Press', 3, 'LegPress.gif', NULL),
(108, 1, 11, 'Hack Squats Machine', 5, 'HackSquatsMachine.gif', NULL),
(109, 1, 11, 'Leg Extension', 3, 'LegExtension.gif', NULL),
(110, 1, 11, 'Squat', 7, 'Squat.gif', NULL),
(111, 1, 11, 'Dumbbell Lunge', 3, NULL, 'DumbbellLunge.gif'),
(112, 1, 11, 'Barbell Bulgarian Split Squat', 7, 'BarbellBulgarianSplitSquat.gif', NULL),
(113, 1, 11, 'Lever Deadlift', 5, 'LeverDeadlift.gif', NULL),
(114, 1, 11, 'Dumbbell Straight Leg Deadlift', 3, 'DumbbellStraightLegDeadlift.gif', NULL),
(115, 1, 11, 'Barbell Lunge', 3, 'BarbellLunge.gif', NULL),
(116, 1, 11, 'Jump Squats', 3, NULL, 'JumpSquats.gif'),
(117, 1, 11, 'Lever Single Leg Curl', 5, 'LeverSingleLegCurl.gif', NULL),
(118, 1, 11, 'High Knee Run', 3, 'HighKneeRun.gif', NULL),
(119, 1, 11, 'Dumbbell Goblet Squats', 3, NULL, 'DumbbellGobletSquats.gif'),
(120, 1, 11, 'Goblet Squats', 3, NULL, 'GobletSquats.gif'),
(121, 1, 11, 'Barbell Romanian Deadlift', 5, 'BarbellRomanianDeadlift.gif', NULL),
(122, 1, 11, 'Barbell Deadlift', 7, 'BarbellDeadlift.gif', NULL),
(123, 2, 12, 'Running On Treadmill', 14, NULL, 'RunningOnTreadmill.gif'),
(124, 2, 12, 'Incline Treadmill', 14, 'InclineTreadmill.gif', NULL),
(125, 2, 12, 'Jumping Jacks', 5, NULL, 'JumpingJacks.gif'),
(126, 2, 12, 'Rowing Machine', 5, NULL, 'RowingMachine.gif'),
(127, 2, 12, 'Battle Rope', 12, 'BattleRope.gif', NULL),
(128, 2, 12, 'High Knee Run', 5, 'HighKneeRun.gif', NULL),
(129, 2, 12, 'Jump Rope', 7, 'JumpRope.gif', NULL),
(130, 2, 12, 'The Box Jump', 7, 'TheBoxJump.gif', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_formula`
--

CREATE TABLE `tbl_formula` (
  `id_formula` int(3) NOT NULL,
  `code_formula` varchar(3) NOT NULL,
  `code_bmi` varchar(3) NOT NULL,
  `code_frequency` varchar(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_formula`
--

INSERT INTO `tbl_formula` (`id_formula`, `code_formula`, `code_bmi`, `code_frequency`) VALUES
(20, 'P01', 'C01', 'L01'),
(21, 'P02', 'C01', 'L02'),
(22, 'P03', 'C01', 'L03'),
(23, 'P04', 'C02', 'L01'),
(24, 'P05', 'C02', 'L02'),
(25, 'P06', 'C02', 'L03'),
(26, 'P07', 'C03', 'L01'),
(27, 'P08', 'C03', 'L02'),
(28, 'P09', 'C03', 'L03'),
(29, 'P10', 'C04', 'L01'),
(30, 'P11', 'C04', 'L02'),
(31, 'P12', 'C04', 'L03'),
(32, 'P13', 'C05', 'L01'),
(33, 'P14', 'C05', 'L02'),
(34, 'P15', 'C05', 'L03'),
(35, 'P16', 'C06', 'L01'),
(40, 'P17', 'C06', 'L02'),
(41, 'P18', 'C06', 'L03');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_formula_workout`
--

CREATE TABLE `tbl_formula_workout` (
  `id_formula_workout` int(9) NOT NULL,
  `code_formula` varchar(3) NOT NULL,
  `id_type_workout` int(9) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_formula_workout`
--

INSERT INTO `tbl_formula_workout` (`id_formula_workout`, `code_formula`, `id_type_workout`) VALUES
(1, 'P01', 1),
(2, 'P02', 1),
(3, 'P03', 1),
(4, 'P04', 1),
(5, 'P04', 2),
(6, 'P04', 3),
(7, 'P05', 1),
(8, 'P05', 2),
(9, 'P05', 3),
(10, 'P06', 1),
(11, 'P06', 2),
(12, 'P06', 3),
(13, 'P07', 1),
(14, 'P07', 2),
(15, 'P07', 3),
(16, 'P08', 1),
(17, 'P08', 2),
(18, 'P08', 3),
(19, 'P09', 1),
(20, 'P09', 2),
(21, 'P09', 3),
(22, 'P10', 1),
(23, 'P10', 2),
(24, 'P11', 1),
(25, 'P11', 2),
(26, 'P12', 1),
(27, 'P12', 2),
(28, 'P13', 1),
(29, 'P13', 3),
(30, 'P14', 1),
(31, 'P14', 3),
(32, 'P15', 1),
(33, 'P15', 3),
(34, 'P16', 1),
(35, 'P16', 3),
(42, 'P17', 1),
(43, 'P17', 3),
(44, 'P18', 1),
(45, 'P18', 3);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_frequency`
--

CREATE TABLE `tbl_frequency` (
  `id_frequency` int(6) NOT NULL,
  `code_frequency` varchar(3) NOT NULL,
  `level_frequency` varchar(52) NOT NULL,
  `desc_frequency` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_frequency`
--

INSERT INTO `tbl_frequency` (`id_frequency`, `code_frequency`, `level_frequency`, `desc_frequency`) VALUES
(14, 'L01', 'Beginner', 'Sudah pernah menjalani workout selama 0 s.d 6 bulan'),
(15, 'L02', 'Intermediate', 'Sudah pernah menjalani workout selama 6 s.d 12 bulan'),
(16, 'L03', 'Advance', 'Sudah pernah menjalani workout lebih dari 12 bulan');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_program`
--

CREATE TABLE `tbl_program` (
  `id_program` int(9) NOT NULL,
  `code_program` varchar(6) NOT NULL,
  `code_formula` varchar(3) NOT NULL,
  `code_frequency` varchar(3) NOT NULL,
  `code_bmi` varchar(3) NOT NULL,
  `id_user` int(6) NOT NULL,
  `id_trainer` int(6) NOT NULL,
  `date_program` date NOT NULL,
  `age_program` int(6) NOT NULL,
  `weight_program` int(6) NOT NULL,
  `height_program` int(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_schedule`
--

CREATE TABLE `tbl_schedule` (
  `id_schedule` int(9) NOT NULL,
  `code_program` varchar(6) NOT NULL,
  `date_schedule` date NOT NULL,
  `rest_schedule` varchar(3) NOT NULL,
  `status_schedule` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_set_training`
--

CREATE TABLE `tbl_set_training` (
  `id_set_training` int(9) NOT NULL,
  `id_training` int(9) NOT NULL,
  `calory_set_training` varchar(9) NOT NULL,
  `time_set_training` varchar(9) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_training`
--

CREATE TABLE `tbl_training` (
  `id_training` int(9) NOT NULL,
  `id_schedule` int(9) DEFAULT NULL,
  `id_exercise` int(9) NOT NULL,
  `name_training` char(52) DEFAULT NULL,
  `calory_exercise` varchar(9) DEFAULT NULL,
  `time_exercise` varchar(9) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_type_workout`
--

CREATE TABLE `tbl_type_workout` (
  `id_type_workout` int(9) NOT NULL,
  `name_type_workout` text NOT NULL,
  `desc_type_workout` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_type_workout`
--

INSERT INTO `tbl_type_workout` (`id_type_workout`, `name_type_workout`, `desc_type_workout`) VALUES
(1, 'Weightlifting', 'Penguatan otot dan ketahanan'),
(2, 'Cardiovascular', 'Peningkatan denyut jantung'),
(3, 'Crossfit', 'Peningkatan mobilitas dan fleksibilitas');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_users`
--

CREATE TABLE `tbl_users` (
  `id_user` int(6) NOT NULL,
  `role_user` enum('Trainer','Client','Admin') NOT NULL,
  `username_user` varchar(12) NOT NULL,
  `email_user` varchar(52) NOT NULL,
  `password_user` varchar(255) NOT NULL,
  `gender_user` enum('Man','Woman') NOT NULL,
  `age_user` smallint(5) DEFAULT NULL,
  `weight_user` smallint(5) DEFAULT NULL,
  `height_user` smallint(5) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_users`
--

INSERT INTO `tbl_users` (`id_user`, `role_user`, `username_user`, `email_user`, `password_user`, `gender_user`, `age_user`, `weight_user`, `height_user`) VALUES
(1, 'Admin', 'admin', 'admin', '$2y$10$TtMhgulYAxqnxuN.2IaZ0.Ll9hh.0HSrBWmnMZcqbGe86DW3QOw5.', 'Man', NULL, NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_bmi`
--
ALTER TABLE `tbl_bmi`
  ADD PRIMARY KEY (`id_bmi`);

--
-- Indexes for table `tbl_bodypart`
--
ALTER TABLE `tbl_bodypart`
  ADD PRIMARY KEY (`id_bodypart`);

--
-- Indexes for table `tbl_exercise`
--
ALTER TABLE `tbl_exercise`
  ADD PRIMARY KEY (`id_exercise`),
  ADD KEY `id_bodypart` (`id_bodypart`),
  ADD KEY `id_type_workout` (`id_type_workout`);

--
-- Indexes for table `tbl_formula`
--
ALTER TABLE `tbl_formula`
  ADD PRIMARY KEY (`id_formula`),
  ADD UNIQUE KEY `code_formula` (`code_formula`),
  ADD KEY `code_bmi` (`code_bmi`),
  ADD KEY `code_frequency` (`code_frequency`);

--
-- Indexes for table `tbl_formula_workout`
--
ALTER TABLE `tbl_formula_workout`
  ADD PRIMARY KEY (`id_formula_workout`),
  ADD KEY `code_formula` (`code_formula`),
  ADD KEY `it_type_workout` (`id_type_workout`);

--
-- Indexes for table `tbl_frequency`
--
ALTER TABLE `tbl_frequency`
  ADD PRIMARY KEY (`id_frequency`),
  ADD UNIQUE KEY `code_frequency` (`code_frequency`);

--
-- Indexes for table `tbl_program`
--
ALTER TABLE `tbl_program`
  ADD PRIMARY KEY (`id_program`),
  ADD UNIQUE KEY `code_program` (`code_program`),
  ADD KEY `id_frequency` (`code_frequency`),
  ADD KEY `id_bmi` (`code_bmi`),
  ADD KEY `id_user` (`id_user`),
  ADD KEY `id_trainer` (`id_trainer`),
  ADD KEY `code_formula` (`code_formula`);

--
-- Indexes for table `tbl_schedule`
--
ALTER TABLE `tbl_schedule`
  ADD PRIMARY KEY (`id_schedule`);

--
-- Indexes for table `tbl_set_training`
--
ALTER TABLE `tbl_set_training`
  ADD PRIMARY KEY (`id_set_training`),
  ADD KEY `id_training` (`id_training`);

--
-- Indexes for table `tbl_training`
--
ALTER TABLE `tbl_training`
  ADD PRIMARY KEY (`id_training`),
  ADD KEY `id_exercise` (`id_exercise`),
  ADD KEY `id_schedule` (`id_schedule`);

--
-- Indexes for table `tbl_type_workout`
--
ALTER TABLE `tbl_type_workout`
  ADD PRIMARY KEY (`id_type_workout`);

--
-- Indexes for table `tbl_users`
--
ALTER TABLE `tbl_users`
  ADD PRIMARY KEY (`id_user`),
  ADD UNIQUE KEY `username_user` (`username_user`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_bmi`
--
ALTER TABLE `tbl_bmi`
  MODIFY `id_bmi` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `tbl_bodypart`
--
ALTER TABLE `tbl_bodypart`
  MODIFY `id_bodypart` int(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `tbl_exercise`
--
ALTER TABLE `tbl_exercise`
  MODIFY `id_exercise` int(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=131;

--
-- AUTO_INCREMENT for table `tbl_formula`
--
ALTER TABLE `tbl_formula`
  MODIFY `id_formula` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `tbl_formula_workout`
--
ALTER TABLE `tbl_formula_workout`
  MODIFY `id_formula_workout` int(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT for table `tbl_frequency`
--
ALTER TABLE `tbl_frequency`
  MODIFY `id_frequency` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `tbl_program`
--
ALTER TABLE `tbl_program`
  MODIFY `id_program` int(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `tbl_schedule`
--
ALTER TABLE `tbl_schedule`
  MODIFY `id_schedule` int(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=305;

--
-- AUTO_INCREMENT for table `tbl_set_training`
--
ALTER TABLE `tbl_set_training`
  MODIFY `id_set_training` int(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=67;

--
-- AUTO_INCREMENT for table `tbl_training`
--
ALTER TABLE `tbl_training`
  MODIFY `id_training` int(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

--
-- AUTO_INCREMENT for table `tbl_type_workout`
--
ALTER TABLE `tbl_type_workout`
  MODIFY `id_type_workout` int(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `tbl_users`
--
ALTER TABLE `tbl_users`
  MODIFY `id_user` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
