<?php

declare(strict_types=1);

namespace App\Enums;

use App\Traits\HasEnumOptions;

enum JobName: string
{
    use HasEnumOptions;

    // General Maintenance
    case OIL_CHANGE = 'oil_change';
    case OIL_FILTER_REPLACEMENT = 'oil_filter_replacement';
    case AIR_FILTER_REPLACEMENT = 'air_filter_replacement';
    case CABIN_FILTER_REPLACEMENT = 'cabin_filter_replacement';
    case FUEL_FILTER_REPLACEMENT = 'fuel_filter_replacement';
    case SPARK_PLUG_REPLACEMENT = 'spark_plug_replacement';
    case GLOW_PLUG_REPLACEMENT = 'glow_plug_replacement';
    case FLUID_TOP_UP = 'fluid_top_up';
    case COOLANT_CHANGE = 'coolant_change';
    case BRAKE_FLUID_CHANGE = 'brake_fluid_change';
    case POWER_STEERING_FLUID_CHANGE = 'power_steering_fluid_change';
    case TRANSMISSION_FLUID_CHANGE = 'transmission_fluid_change';
    case DIFFERENTIAL_FLUID_CHANGE = 'differential_fluid_change';
    case TRANSFER_CASE_FLUID_CHANGE = 'transfer_case_fluid_change';
    case SERVICE_INTERVAL = 'service_interval';
    case MAJOR_SERVICE = 'major_service';
    case MINOR_SERVICE = 'minor_service';

    // Engine
    case ENGINE_DIAGNOSTICS = 'engine_diagnostics';
    case ENGINE_TUNE_UP = 'engine_tune_up';
    case ENGINE_INSPECTION = 'engine_inspection';
    case ENGINE_REPAIR = 'engine_repair';
    case ENGINE_REBUILD = 'engine_rebuild';
    case ENGINE_REPLACEMENT = 'engine_replacement';
    case TIMING_BELT_REPLACEMENT = 'timing_belt_replacement';
    case TIMING_CHAIN_REPLACEMENT = 'timing_chain_replacement';
    case TIMING_CHAIN_TENSIONER_REPLACEMENT = 'timing_chain_tensioner_replacement';
    case WATER_PUMP_REPLACEMENT = 'water_pump_replacement';
    case THERMOSTAT_REPLACEMENT = 'thermostat_replacement';
    case RADIATOR_REPLACEMENT = 'radiator_replacement';
    case RADIATOR_REPAIR = 'radiator_repair';
    case COOLING_SYSTEM_FLUSH = 'cooling_system_flush';
    case COOLING_SYSTEM_REPAIR = 'cooling_system_repair';
    case ENGINE_MOUNT_REPLACEMENT = 'engine_mount_replacement';
    case HEAD_GASKET_REPLACEMENT = 'head_gasket_replacement';
    case VALVE_COVER_GASKET_REPLACEMENT = 'valve_cover_gasket_replacement';
    case OIL_PAN_GASKET_REPLACEMENT = 'oil_pan_gasket_replacement';
    case CRANKSHAFT_SEAL_REPLACEMENT = 'crankshaft_seal_replacement';
    case CAMSHAFT_SEAL_REPLACEMENT = 'camshaft_seal_replacement';
    case INTAKE_MANIFOLD_REPAIR = 'intake_manifold_repair';
    case EXHAUST_MANIFOLD_REPAIR = 'exhaust_manifold_repair';
    case EGR_VALVE_REPLACEMENT = 'egr_valve_replacement';
    case TURBOCHARGER_REPAIR = 'turbocharger_repair';
    case TURBOCHARGER_REPLACEMENT = 'turbocharger_replacement';
    case SUPERCHARGER_REPAIR = 'supercharger_repair';
    case SUPERCHARGER_REPLACEMENT = 'supercharger_replacement';
    case PCV_SYSTEM_REPAIR = 'pcv_system_repair';
    case ENGINE_BELT_REPLACEMENT = 'engine_belt_replacement';
    case ENGINE_LEAK_REPAIR = 'engine_leak_repair';

    // Fuel & Injection
    case FUEL_SYSTEM_DIAGNOSTICS = 'fuel_system_diagnostics';
    case FUEL_SYSTEM_REPAIR = 'fuel_system_repair';
    case FUEL_PUMP_REPLACEMENT = 'fuel_pump_replacement';
    case FUEL_INJECTOR_REPLACEMENT = 'fuel_injector_replacement';
    case FUEL_INJECTOR_CLEANING = 'fuel_injector_cleaning';
    case FUEL_TANK_REPAIR = 'fuel_tank_repair';
    case FUEL_FILTER_HOUSING_REPLACEMENT = 'fuel_filter_housing_replacement';
    case CARBURETOR_SERVICE = 'carburetor_service';
    case THROTTLE_BODY_CLEANING = 'throttle_body_cleaning';
    case THROTTLE_BODY_REPLACEMENT = 'throttle_body_replacement';

    // Brakes
    case BRAKE_INSPECTION = 'brake_inspection';
    case BRAKE_DIAGNOSTICS = 'brake_diagnostics';
    case BRAKE_PAD_REPLACEMENT = 'brake_pad_replacement';
    case BRAKE_DISC_REPLACEMENT = 'brake_disc_replacement';
    case BRAKE_DRUM_REPLACEMENT = 'brake_drum_replacement';
    case BRAKE_SHOE_REPLACEMENT = 'brake_shoe_replacement';
    case BRAKE_CALIPER_REPAIR = 'brake_caliper_repair';
    case BRAKE_CALIPER_REPLACEMENT = 'brake_caliper_replacement';
    case BRAKE_HOSE_REPLACEMENT = 'brake_hose_replacement';
    case BRAKE_LINE_REPAIR = 'brake_line_repair';
    case BRAKE_MASTER_CYLINDER_REPLACEMENT = 'brake_master_cylinder_replacement';
    case BRAKE_BOOSTER_REPLACEMENT = 'brake_booster_replacement';
    case BRAKE_FLUID_FLUSH = 'brake_fluid_flush';
    case PARKING_BRAKE_REPAIR = 'parking_brake_repair';
    case ELECTRIC_PARKING_BRAKE_SERVICE = 'electric_parking_brake_service';
    case ABS_DIAGNOSTICS = 'abs_diagnostics';
    case ABS_SENSOR_REPLACEMENT = 'abs_sensor_replacement';
    case ABS_REPAIR = 'abs_repair';

    // Suspension & Steering
    case SUSPENSION_INSPECTION = 'suspension_inspection';
    case SUSPENSION_DIAGNOSTICS = 'suspension_diagnostics';
    case SHOCK_ABSORBER_REPLACEMENT = 'shock_absorber_replacement';
    case STRUT_REPLACEMENT = 'strut_replacement';
    case COIL_SPRING_REPLACEMENT = 'coil_spring_replacement';
    case AIR_SUSPENSION_REPAIR = 'air_suspension_repair';
    case AIR_SUSPENSION_CALIBRATION = 'air_suspension_calibration';
    case CONTROL_ARM_REPLACEMENT = 'control_arm_replacement';
    case CONTROL_ARM_BUSH_REPLACEMENT = 'control_arm_bush_replacement';
    case BALL_JOINT_REPLACEMENT = 'ball_joint_replacement';
    case STABILIZER_LINK_REPLACEMENT = 'stabilizer_link_replacement';
    case STABILIZER_BUSH_REPLACEMENT = 'stabilizer_bush_replacement';
    case WHEEL_BEARING_REPLACEMENT = 'wheel_bearing_replacement';
    case STEERING_INSPECTION = 'steering_inspection';
    case STEERING_REPAIR = 'steering_repair';
    case POWER_STEERING_REPAIR = 'power_steering_repair';
    case POWER_STEERING_PUMP_REPLACEMENT = 'power_steering_pump_replacement';
    case STEERING_RACK_REPLACEMENT = 'steering_rack_replacement';
    case TIE_ROD_REPLACEMENT = 'tie_rod_replacement';
    case STEERING_COLUMN_REPAIR = 'steering_column_repair';
    case WHEEL_ALIGNMENT = 'wheel_alignment';
    case FOUR_WHEEL_ALIGNMENT = 'four_wheel_alignment';

    // Wheels & Tyres
    case TYRE_INSPECTION = 'tyre_inspection';
    case TYRE_REPLACEMENT = 'tyre_replacement';
    case TYRE_REPAIR = 'tyre_repair';
    case TYRE_ROTATION = 'tyre_rotation';
    case TYRE_BALANCING = 'tyre_balancing';
    case WHEEL_BALANCING = 'wheel_balancing';
    case WHEEL_REPLACEMENT = 'wheel_replacement';
    case WHEEL_REPAIR = 'wheel_repair';
    case WHEEL_ALIGNMENT_CHECK = 'wheel_alignment_check';
    case TPMS_DIAGNOSTICS = 'tpms_diagnostics';
    case TPMS_SENSOR_REPLACEMENT = 'tpms_sensor_replacement';
    case TPMS_RESET = 'tpms_reset';
    case SEASONAL_TYRE_CHANGE = 'seasonal_tyre_change';

    // Transmission & Drivetrain
    case TRANSMISSION_DIAGNOSTICS = 'transmission_diagnostics';
    case TRANSMISSION_INSPECTION = 'transmission_inspection';
    case TRANSMISSION_REPAIR = 'transmission_repair';
    case TRANSMISSION_REBUILD = 'transmission_rebuild';
    case TRANSMISSION_REPLACEMENT = 'transmission_replacement';
    case AUTOMATIC_TRANSMISSION_SERVICE = 'automatic_transmission_service';
    case MANUAL_TRANSMISSION_SERVICE = 'manual_transmission_service';
    case CLUTCH_INSPECTION = 'clutch_inspection';
    case CLUTCH_REPLACEMENT = 'clutch_replacement';
    case DUAL_MASS_FLYWHEEL_REPLACEMENT = 'dual_mass_flywheel_replacement';
    case FLYWHEEL_REPLACEMENT = 'flywheel_replacement';
    case CLUTCH_HYDRAULIC_REPAIR = 'clutch_hydraulic_repair';
    case CV_JOINT_REPLACEMENT = 'cv_joint_replacement';
    case CV_AXLE_REPLACEMENT = 'cv_axle_replacement';
    case DRIVE_SHAFT_REPLACEMENT = 'drive_shaft_replacement';
    case DIFFERENTIAL_REPAIR = 'differential_repair';
    case DIFFERENTIAL_REPLACEMENT = 'differential_replacement';
    case TRANSFER_CASE_REPAIR = 'transfer_case_repair';
    case TRANSFER_CASE_REPLACEMENT = 'transfer_case_replacement';
    case FOUR_WHEEL_DRIVE_SERVICE = 'four_wheel_drive_service';
    case ALL_WHEEL_DRIVE_SERVICE = 'all_wheel_drive_service';

    // Electrical
    case ELECTRICAL_DIAGNOSTICS = 'electrical_diagnostics';
    case BATTERY_INSPECTION = 'battery_inspection';
    case BATTERY_REPLACEMENT = 'battery_replacement';
    case BATTERY_TEST = 'battery_test';
    case BATTERY_CHARGING = 'battery_charging';
    case ALTERNATOR_DIAGNOSTICS = 'alternator_diagnostics';
    case ALTERNATOR_REPAIR = 'alternator_repair';
    case ALTERNATOR_REPLACEMENT = 'alternator_replacement';
    case STARTER_DIAGNOSTICS = 'starter_diagnostics';
    case STARTER_REPAIR = 'starter_repair';
    case STARTER_REPLACEMENT = 'starter_replacement';
    case WIRING_REPAIR = 'wiring_repair';
    case FUSE_REPLACEMENT = 'fuse_replacement';
    case RELAY_REPLACEMENT = 'relay_replacement';
    case ECU_DIAGNOSTICS = 'ecu_diagnostics';
    case ECU_REPAIR = 'ecu_repair';
    case ECU_REPLACEMENT = 'ecu_replacement';
    case ECU_PROGRAMMING = 'ecu_programming';
    case SOFTWARE_UPDATE = 'software_update';
    case KEY_PROGRAMMING = 'key_programming';
    case IMMOBILIZER_DIAGNOSTICS = 'immobilizer_diagnostics';
    case IMMOBILIZER_REPAIR = 'immobilizer_repair';

    // Lighting & Visibility
    case HEADLIGHT_REPLACEMENT = 'headlight_replacement';
    case HEADLIGHT_REPAIR = 'headlight_repair';
    case HEADLIGHT_ALIGNMENT = 'headlight_alignment';
    case HEADLIGHT_RESTORATION = 'headlight_restoration';
    case BULB_REPLACEMENT = 'bulb_replacement';
    case TAILLIGHT_REPLACEMENT = 'taillight_replacement';
    case INDICATOR_REPAIR = 'indicator_repair';
    case WINDSCREEN_WIPER_REPLACEMENT = 'windscreen_wiper_replacement';
    case WINDSCREEN_WASHER_REPAIR = 'windscreen_washer_repair';
    case WINDSCREEN_REPLACEMENT = 'windscreen_replacement';
    case WINDSCREEN_REPAIR = 'windscreen_repair';

    // Air Conditioning & HVAC
    case AC_DIAGNOSTICS = 'ac_diagnostics';
    case AC_RECHARGE = 'ac_recharge';
    case AC_SERVICE = 'ac_service';
    case AC_REPAIR = 'ac_repair';
    case AC_COMPRESSOR_REPLACEMENT = 'ac_compressor_replacement';
    case AC_CONDENSER_REPLACEMENT = 'ac_condenser_replacement';
    case AC_EVAPORATOR_REPLACEMENT = 'ac_evaporator_replacement';
    case AC_EXPANSION_VALVE_REPLACEMENT = 'ac_expansion_valve_replacement';
    case AC_LEAK_TEST = 'ac_leak_test';
    case HEATER_REPAIR = 'heater_repair';
    case BLOWER_MOTOR_REPLACEMENT = 'blower_motor_replacement';
    case HVAC_FILTER_REPLACEMENT = 'hvac_filter_replacement';
    case HVAC_DIAGNOSTICS = 'hvac_diagnostics';

    // Exhaust & Emissions
    case EXHAUST_INSPECTION = 'exhaust_inspection';
    case EXHAUST_REPAIR = 'exhaust_repair';
    case EXHAUST_REPLACEMENT = 'exhaust_replacement';
    case MUFFLER_REPLACEMENT = 'muffler_replacement';
    case CATALYTIC_CONVERTER_REPLACEMENT = 'catalytic_converter_replacement';
    case DPF_DIAGNOSTICS = 'dpf_diagnostics';
    case DPF_CLEANING = 'dpf_cleaning';
    case DPF_REGENERATION = 'dpf_regeneration';
    case DPF_REPLACEMENT = 'dpf_replacement';
    case SCR_SYSTEM_DIAGNOSTICS = 'scr_system_diagnostics';
    case ADBLUE_SYSTEM_SERVICE = 'adblue_system_service';
    case ADBLUE_TOP_UP = 'adblue_top_up';
    case NOX_SENSOR_REPLACEMENT = 'nox_sensor_replacement';
    case OXYGEN_SENSOR_REPLACEMENT = 'oxygen_sensor_replacement';
    case EMISSIONS_DIAGNOSTICS = 'emissions_diagnostics';
    case EGR_SYSTEM_SERVICE = 'egr_system_service';

    // Diagnostics & Electronics
    case FULL_VEHICLE_DIAGNOSTICS = 'full_vehicle_diagnostics';
    case OBD_DIAGNOSTICS = 'obd_diagnostics';
    case FAULT_CODE_DIAGNOSTICS = 'fault_code_diagnostics';
    case FAULT_CODE_CLEARING = 'fault_code_clearing';
    case MODULE_DIAGNOSTICS = 'module_diagnostics';
    case SENSOR_DIAGNOSTICS = 'sensor_diagnostics';
    case SENSOR_REPLACEMENT = 'sensor_replacement';
    case CALIBRATION = 'calibration';
    case CODING = 'coding';
    case ADAPTATION = 'adaptation';
    case RESET_SERVICE_INTERVAL = 'reset_service_interval';
    case RESET_ADAPTATIONS = 'reset_adaptations';

    // ADAS & Driver Assistance
    case ADAS_DIAGNOSTICS = 'adas_diagnostics';
    case ADAS_CALIBRATION = 'adas_calibration';
    case CAMERA_CALIBRATION = 'camera_calibration';
    case RADAR_CALIBRATION = 'radar_calibration';
    case PARKING_SENSOR_REPLACEMENT = 'parking_sensor_replacement';
    case PARKING_SENSOR_DIAGNOSTICS = 'parking_sensor_diagnostics';
    case BLIND_SPOT_SENSOR_REPLACEMENT = 'blind_spot_sensor_replacement';
    case BLIND_SPOT_SYSTEM_DIAGNOSTICS = 'blind_spot_system_diagnostics';

    // Bodywork
    case BODY_INSPECTION = 'body_inspection';
    case BODY_REPAIR = 'body_repair';
    case DENT_REPAIR = 'dent_repair';
    case PAINT_REPAIR = 'paint_repair';
    case PANEL_REPLACEMENT = 'panel_replacement';
    case BUMPER_REPAIR = 'bumper_repair';
    case BUMPER_REPLACEMENT = 'bumper_replacement';
    case BONNET_REPAIR = 'bonnet_repair';
    case BONNET_REPLACEMENT = 'bonnet_replacement';
    case DOOR_REPAIR = 'door_repair';
    case DOOR_REPLACEMENT = 'door_replacement';
    case WING_REPAIR = 'wing_repair';
    case WING_REPLACEMENT = 'wing_replacement';
    case BOOT_REPAIR = 'boot_repair';
    case BOOT_REPLACEMENT = 'boot_replacement';
    case MIRROR_REPAIR = 'mirror_repair';
    case MIRROR_REPLACEMENT = 'mirror_replacement';
    case FRAME_REPAIR = 'frame_repair';
    case CHASSIS_REPAIR = 'chassis_repair';
    case RUST_REPAIR = 'rust_repair';
    case UNDERBODY_REPAIR = 'underbody_repair';

    // Interior
    case INTERIOR_INSPECTION = 'interior_inspection';
    case INTERIOR_REPAIR = 'interior_repair';
    case SEAT_REPAIR = 'seat_repair';
    case SEAT_REPLACEMENT = 'seat_replacement';
    case CARPET_REPLACEMENT = 'carpet_replacement';
    case DASHBOARD_REPAIR = 'dashboard_repair';
    case INTERIOR_TRIM_REPAIR = 'interior_trim_repair';
    case SUNROOF_REPAIR = 'sunroof_repair';
    case WINDOW_REGULATOR_REPLACEMENT = 'window_regulator_replacement';
    case WINDOW_MOTOR_REPLACEMENT = 'window_motor_replacement';
    case CENTRAL_LOCKING_REPAIR = 'central_locking_repair';

    // Safety
    case AIRBAG_DIAGNOSTICS = 'airbag_diagnostics';
    case AIRBAG_REPLACEMENT = 'airbag_replacement';
    case SEATBELT_REPAIR = 'seatbelt_repair';
    case SEATBELT_REPLACEMENT = 'seatbelt_replacement';
    case SRS_DIAGNOSTICS = 'srs_diagnostics';
    case SRS_REPAIR = 'srs_repair';

    // EV / Hybrid
    case EV_DIAGNOSTICS = 'ev_diagnostics';
    case EV_BATTERY_DIAGNOSTICS = 'ev_battery_diagnostics';
    case EV_BATTERY_SERVICE = 'ev_battery_service';
    case EV_BATTERY_REPAIR = 'ev_battery_repair';
    case EV_BATTERY_REPLACEMENT = 'ev_battery_replacement';
    case EV_BATTERY_BALANCING = 'ev_battery_balancing';
    case EV_CHARGING_SYSTEM_DIAGNOSTICS = 'ev_charging_system_diagnostics';
    case CHARGING_PORT_REPAIR = 'charging_port_repair';
    case ONBOARD_CHARGER_REPAIR = 'onboard_charger_repair';
    case ONBOARD_CHARGER_REPLACEMENT = 'onboard_charger_replacement';
    case DC_DC_CONVERTER_REPAIR = 'dc_dc_converter_repair';
    case DC_DC_CONVERTER_REPLACEMENT = 'dc_dc_converter_replacement';
    case INVERTER_REPAIR = 'inverter_repair';
    case INVERTER_REPLACEMENT = 'inverter_replacement';
    case HYBRID_SYSTEM_DIAGNOSTICS = 'hybrid_system_diagnostics';
    case HYBRID_BATTERY_SERVICE = 'hybrid_battery_service';
    case HIGH_VOLTAGE_SYSTEM_INSPECTION = 'high_voltage_system_inspection';

    // Inspection & Roadworthiness
    case VEHICLE_INSPECTION = 'vehicle_inspection';
    case SAFETY_INSPECTION = 'safety_inspection';
    case PRE_PURCHASE_INSPECTION = 'pre_purchase_inspection';
    case PRE_TRIP_INSPECTION = 'pre_trip_inspection';
    case ROADWORTHINESS_INSPECTION = 'roadworthiness_inspection';
    case EMISSIONS_TEST = 'emissions_test';
    case VEHICLE_CERTIFICATION_INSPECTION = 'vehicle_certification_inspection';
    case POST_REPAIR_INSPECTION = 'post_repair_inspection';
    case QUALITY_CONTROL_INSPECTION = 'quality_control_inspection';

    // Cleaning & Detailing
    case VEHICLE_CLEANING = 'vehicle_cleaning';
    case INTERIOR_CLEANING = 'interior_cleaning';
    case EXTERIOR_CLEANING = 'exterior_cleaning';
    case ENGINE_BAY_CLEANING = 'engine_bay_cleaning';
    case CARPET_CLEANING = 'carpet_cleaning';
    case UPHOLSTERY_CLEANING = 'upholstery_cleaning';
    case PAINT_CORRECTION = 'paint_correction';
    case PAINT_POLISHING = 'paint_polishing';
    case PAINT_PROTECTION = 'paint_protection';
    case CERAMIC_COATING = 'ceramic_coating';
    case HEADLIGHT_POLISHING = 'headlight_polishing';

    // Recovery / Other
    case VEHICLE_RECOVERY = 'vehicle_recovery';
    case ROADSIDE_ASSISTANCE = 'roadside_assistance';
    case TOWING = 'towing';
    case DIAGNOSTIC_INSPECTION = 'diagnostic_inspection';
    case GENERAL_REPAIR = 'general_repair';
    case GENERAL_SERVICE = 'general_service';
    case OTHER = 'other';

    public function label(): string
    {
        return match ($this) {
            self::OIL_CHANGE => 'Oil Change',
            self::OIL_FILTER_REPLACEMENT => 'Oil Filter Replacement',
            self::AIR_FILTER_REPLACEMENT => 'Air Filter Replacement',
            self::CABIN_FILTER_REPLACEMENT => 'Cabin Filter Replacement',
            self::FUEL_FILTER_REPLACEMENT => 'Fuel Filter Replacement',
            self::SPARK_PLUG_REPLACEMENT => 'Spark Plug Replacement',
            self::GLOW_PLUG_REPLACEMENT => 'Glow Plug Replacement',
            self::FLUID_TOP_UP => 'Fluid Top-Up',
            self::COOLANT_CHANGE => 'Coolant Change',
            self::BRAKE_FLUID_CHANGE => 'Brake Fluid Change',
            self::POWER_STEERING_FLUID_CHANGE => 'Power Steering Fluid Change',
            self::TRANSMISSION_FLUID_CHANGE => 'Transmission Fluid Change',
            self::DIFFERENTIAL_FLUID_CHANGE => 'Differential Fluid Change',
            self::TRANSFER_CASE_FLUID_CHANGE => 'Transfer Case Fluid Change',
            self::SERVICE_INTERVAL => 'Service Interval',
            self::MAJOR_SERVICE => 'Major Service',
            self::MINOR_SERVICE => 'Minor Service',

            self::ENGINE_DIAGNOSTICS => 'Engine Diagnostics',
            self::ENGINE_TUNE_UP => 'Engine Tune-Up',
            self::ENGINE_INSPECTION => 'Engine Inspection',
            self::ENGINE_REPAIR => 'Engine Repair',
            self::ENGINE_REBUILD => 'Engine Rebuild',
            self::ENGINE_REPLACEMENT => 'Engine Replacement',
            self::TIMING_BELT_REPLACEMENT => 'Timing Belt Replacement',
            self::TIMING_CHAIN_REPLACEMENT => 'Timing Chain Replacement',
            self::TIMING_CHAIN_TENSIONER_REPLACEMENT => 'Timing Chain Tensioner Replacement',
            self::WATER_PUMP_REPLACEMENT => 'Water Pump Replacement',
            self::THERMOSTAT_REPLACEMENT => 'Thermostat Replacement',
            self::RADIATOR_REPLACEMENT => 'Radiator Replacement',
            self::RADIATOR_REPAIR => 'Radiator Repair',
            self::COOLING_SYSTEM_FLUSH => 'Cooling System Flush',
            self::COOLING_SYSTEM_REPAIR => 'Cooling System Repair',
            self::ENGINE_MOUNT_REPLACEMENT => 'Engine Mount Replacement',
            self::HEAD_GASKET_REPLACEMENT => 'Head Gasket Replacement',
            self::VALVE_COVER_GASKET_REPLACEMENT => 'Valve Cover Gasket Replacement',
            self::OIL_PAN_GASKET_REPLACEMENT => 'Oil Pan Gasket Replacement',
            self::CRANKSHAFT_SEAL_REPLACEMENT => 'Crankshaft Seal Replacement',
            self::CAMSHAFT_SEAL_REPLACEMENT => 'Camshaft Seal Replacement',
            self::INTAKE_MANIFOLD_REPAIR => 'Intake Manifold Repair',
            self::EXHAUST_MANIFOLD_REPAIR => 'Exhaust Manifold Repair',
            self::EGR_VALVE_REPLACEMENT => 'EGR Valve Replacement',
            self::TURBOCHARGER_REPAIR => 'Turbocharger Repair',
            self::TURBOCHARGER_REPLACEMENT => 'Turbocharger Replacement',
            self::SUPERCHARGER_REPAIR => 'Supercharger Repair',
            self::SUPERCHARGER_REPLACEMENT => 'Supercharger Replacement',
            self::PCV_SYSTEM_REPAIR => 'PCV System Repair',
            self::ENGINE_BELT_REPLACEMENT => 'Engine Belt Replacement',
            self::ENGINE_LEAK_REPAIR => 'Engine Leak Repair',

            self::FUEL_SYSTEM_DIAGNOSTICS => 'Fuel System Diagnostics',
            self::FUEL_SYSTEM_REPAIR => 'Fuel System Repair',
            self::FUEL_PUMP_REPLACEMENT => 'Fuel Pump Replacement',
            self::FUEL_INJECTOR_REPLACEMENT => 'Fuel Injector Replacement',
            self::FUEL_INJECTOR_CLEANING => 'Fuel Injector Cleaning',
            self::FUEL_TANK_REPAIR => 'Fuel Tank Repair',
            self::FUEL_FILTER_HOUSING_REPLACEMENT => 'Fuel Filter Housing Replacement',
            self::CARBURETOR_SERVICE => 'Carburetor Service',
            self::THROTTLE_BODY_CLEANING => 'Throttle Body Cleaning',
            self::THROTTLE_BODY_REPLACEMENT => 'Throttle Body Replacement',

            self::BRAKE_INSPECTION => 'Brake Inspection',
            self::BRAKE_DIAGNOSTICS => 'Brake Diagnostics',
            self::BRAKE_PAD_REPLACEMENT => 'Brake Pad Replacement',
            self::BRAKE_DISC_REPLACEMENT => 'Brake Disc Replacement',
            self::BRAKE_DRUM_REPLACEMENT => 'Brake Drum Replacement',
            self::BRAKE_SHOE_REPLACEMENT => 'Brake Shoe Replacement',
            self::BRAKE_CALIPER_REPAIR => 'Brake Caliper Repair',
            self::BRAKE_CALIPER_REPLACEMENT => 'Brake Caliper Replacement',
            self::BRAKE_HOSE_REPLACEMENT => 'Brake Hose Replacement',
            self::BRAKE_LINE_REPAIR => 'Brake Line Repair',
            self::BRAKE_MASTER_CYLINDER_REPLACEMENT => 'Brake Master Cylinder Replacement',
            self::BRAKE_BOOSTER_REPLACEMENT => 'Brake Booster Replacement',
            self::BRAKE_FLUID_FLUSH => 'Brake Fluid Flush',
            self::PARKING_BRAKE_REPAIR => 'Parking Brake Repair',
            self::ELECTRIC_PARKING_BRAKE_SERVICE => 'Electric Parking Brake Service',
            self::ABS_DIAGNOSTICS => 'ABS Diagnostics',
            self::ABS_SENSOR_REPLACEMENT => 'ABS Sensor Replacement',
            self::ABS_REPAIR => 'ABS Repair',

            self::SUSPENSION_INSPECTION => 'Suspension Inspection',
            self::SUSPENSION_DIAGNOSTICS => 'Suspension Diagnostics',
            self::SHOCK_ABSORBER_REPLACEMENT => 'Shock Absorber Replacement',
            self::STRUT_REPLACEMENT => 'Strut Replacement',
            self::COIL_SPRING_REPLACEMENT => 'Coil Spring Replacement',
            self::AIR_SUSPENSION_REPAIR => 'Air Suspension Repair',
            self::AIR_SUSPENSION_CALIBRATION => 'Air Suspension Calibration',
            self::CONTROL_ARM_REPLACEMENT => 'Control Arm Replacement',
            self::CONTROL_ARM_BUSH_REPLACEMENT => 'Control Arm Bush Replacement',
            self::BALL_JOINT_REPLACEMENT => 'Ball Joint Replacement',
            self::STABILIZER_LINK_REPLACEMENT => 'Stabilizer Link Replacement',
            self::STABILIZER_BUSH_REPLACEMENT => 'Stabilizer Bush Replacement',
            self::WHEEL_BEARING_REPLACEMENT => 'Wheel Bearing Replacement',
            self::STEERING_INSPECTION => 'Steering Inspection',
            self::STEERING_REPAIR => 'Steering Repair',
            self::POWER_STEERING_REPAIR => 'Power Steering Repair',
            self::POWER_STEERING_PUMP_REPLACEMENT => 'Power Steering Pump Replacement',
            self::STEERING_RACK_REPLACEMENT => 'Steering Rack Replacement',
            self::TIE_ROD_REPLACEMENT => 'Tie Rod Replacement',
            self::STEERING_COLUMN_REPAIR => 'Steering Column Repair',
            self::WHEEL_ALIGNMENT => 'Wheel Alignment',
            self::FOUR_WHEEL_ALIGNMENT => 'Four-Wheel Alignment',

            self::TYRE_INSPECTION => 'Tyre Inspection',
            self::TYRE_REPLACEMENT => 'Tyre Replacement',
            self::TYRE_REPAIR => 'Tyre Repair',
            self::TYRE_ROTATION => 'Tyre Rotation',
            self::TYRE_BALANCING => 'Tyre Balancing',
            self::WHEEL_BALANCING => 'Wheel Balancing',
            self::WHEEL_REPLACEMENT => 'Wheel Replacement',
            self::WHEEL_REPAIR => 'Wheel Repair',
            self::WHEEL_ALIGNMENT_CHECK => 'Wheel Alignment Check',
            self::TPMS_DIAGNOSTICS => 'TPMS Diagnostics',
            self::TPMS_SENSOR_REPLACEMENT => 'TPMS Sensor Replacement',
            self::TPMS_RESET => 'TPMS Reset',
            self::SEASONAL_TYRE_CHANGE => 'Seasonal Tyre Change',

            self::TRANSMISSION_DIAGNOSTICS => 'Transmission Diagnostics',
            self::TRANSMISSION_INSPECTION => 'Transmission Inspection',
            self::TRANSMISSION_REPAIR => 'Transmission Repair',
            self::TRANSMISSION_REBUILD => 'Transmission Rebuild',
            self::TRANSMISSION_REPLACEMENT => 'Transmission Replacement',
            self::AUTOMATIC_TRANSMISSION_SERVICE => 'Automatic Transmission Service',
            self::MANUAL_TRANSMISSION_SERVICE => 'Manual Transmission Service',
            self::CLUTCH_INSPECTION => 'Clutch Inspection',
            self::CLUTCH_REPLACEMENT => 'Clutch Replacement',
            self::DUAL_MASS_FLYWHEEL_REPLACEMENT => 'Dual-Mass Flywheel Replacement',
            self::FLYWHEEL_REPLACEMENT => 'Flywheel Replacement',
            self::CLUTCH_HYDRAULIC_REPAIR => 'Clutch Hydraulic Repair',
            self::CV_JOINT_REPLACEMENT => 'CV Joint Replacement',
            self::CV_AXLE_REPLACEMENT => 'CV Axle Replacement',
            self::DRIVE_SHAFT_REPLACEMENT => 'Drive Shaft Replacement',
            self::DIFFERENTIAL_REPAIR => 'Differential Repair',
            self::DIFFERENTIAL_REPLACEMENT => 'Differential Replacement',
            self::TRANSFER_CASE_REPAIR => 'Transfer Case Repair',
            self::TRANSFER_CASE_REPLACEMENT => 'Transfer Case Replacement',
            self::FOUR_WHEEL_DRIVE_SERVICE => 'Four-Wheel Drive Service',
            self::ALL_WHEEL_DRIVE_SERVICE => 'All-Wheel Drive Service',

            self::ELECTRICAL_DIAGNOSTICS => 'Electrical Diagnostics',
            self::BATTERY_INSPECTION => 'Battery Inspection',
            self::BATTERY_REPLACEMENT => 'Battery Replacement',
            self::BATTERY_TEST => 'Battery Test',
            self::BATTERY_CHARGING => 'Battery Charging',
            self::ALTERNATOR_DIAGNOSTICS => 'Alternator Diagnostics',
            self::ALTERNATOR_REPAIR => 'Alternator Repair',
            self::ALTERNATOR_REPLACEMENT => 'Alternator Replacement',
            self::STARTER_DIAGNOSTICS => 'Starter Diagnostics',
            self::STARTER_REPAIR => 'Starter Repair',
            self::STARTER_REPLACEMENT => 'Starter Replacement',
            self::WIRING_REPAIR => 'Wiring Repair',
            self::FUSE_REPLACEMENT => 'Fuse Replacement',
            self::RELAY_REPLACEMENT => 'Relay Replacement',
            self::ECU_DIAGNOSTICS => 'ECU Diagnostics',
            self::ECU_REPAIR => 'ECU Repair',
            self::ECU_REPLACEMENT => 'ECU Replacement',
            self::ECU_PROGRAMMING => 'ECU Programming',
            self::SOFTWARE_UPDATE => 'Software Update',
            self::KEY_PROGRAMMING => 'Key Programming',
            self::IMMOBILIZER_DIAGNOSTICS => 'Immobilizer Diagnostics',
            self::IMMOBILIZER_REPAIR => 'Immobilizer Repair',

            self::HEADLIGHT_REPLACEMENT => 'Headlight Replacement',
            self::HEADLIGHT_REPAIR => 'Headlight Repair',
            self::HEADLIGHT_ALIGNMENT => 'Headlight Alignment',
            self::HEADLIGHT_RESTORATION => 'Headlight Restoration',
            self::BULB_REPLACEMENT => 'Bulb Replacement',
            self::TAILLIGHT_REPLACEMENT => 'Taillight Replacement',
            self::INDICATOR_REPAIR => 'Indicator Repair',
            self::WINDSCREEN_WIPER_REPLACEMENT => 'Windscreen Wiper Replacement',
            self::WINDSCREEN_WASHER_REPAIR => 'Windscreen Washer Repair',
            self::WINDSCREEN_REPLACEMENT => 'Windscreen Replacement',
            self::WINDSCREEN_REPAIR => 'Windscreen Repair',

            self::AC_DIAGNOSTICS => 'A/C Diagnostics',
            self::AC_RECHARGE => 'A/C Recharge',
            self::AC_SERVICE => 'A/C Service',
            self::AC_REPAIR => 'A/C Repair',
            self::AC_COMPRESSOR_REPLACEMENT => 'A/C Compressor Replacement',
            self::AC_CONDENSER_REPLACEMENT => 'A/C Condenser Replacement',
            self::AC_EVAPORATOR_REPLACEMENT => 'A/C Evaporator Replacement',
            self::AC_EXPANSION_VALVE_REPLACEMENT => 'A/C Expansion Valve Replacement',
            self::AC_LEAK_TEST => 'A/C Leak Test',
            self::HEATER_REPAIR => 'Heater Repair',
            self::BLOWER_MOTOR_REPLACEMENT => 'Blower Motor Replacement',
            self::HVAC_FILTER_REPLACEMENT => 'HVAC Filter Replacement',
            self::HVAC_DIAGNOSTICS => 'HVAC Diagnostics',

            self::EXHAUST_INSPECTION => 'Exhaust Inspection',
            self::EXHAUST_REPAIR => 'Exhaust Repair',
            self::EXHAUST_REPLACEMENT => 'Exhaust Replacement',
            self::MUFFLER_REPLACEMENT => 'Muffler Replacement',
            self::CATALYTIC_CONVERTER_REPLACEMENT => 'Catalytic Converter Replacement',
            self::DPF_DIAGNOSTICS => 'DPF Diagnostics',
            self::DPF_CLEANING => 'DPF Cleaning',
            self::DPF_REGENERATION => 'DPF Regeneration',
            self::DPF_REPLACEMENT => 'DPF Replacement',
            self::SCR_SYSTEM_DIAGNOSTICS => 'SCR System Diagnostics',
            self::ADBLUE_SYSTEM_SERVICE => 'AdBlue System Service',
            self::ADBLUE_TOP_UP => 'AdBlue Top-Up',
            self::NOX_SENSOR_REPLACEMENT => 'NOx Sensor Replacement',
            self::OXYGEN_SENSOR_REPLACEMENT => 'Oxygen Sensor Replacement',
            self::EMISSIONS_DIAGNOSTICS => 'Emissions Diagnostics',
            self::EGR_SYSTEM_SERVICE => 'EGR System Service',

            self::FULL_VEHICLE_DIAGNOSTICS => 'Full Vehicle Diagnostics',
            self::OBD_DIAGNOSTICS => 'OBD Diagnostics',
            self::FAULT_CODE_DIAGNOSTICS => 'Fault Code Diagnostics',
            self::FAULT_CODE_CLEARING => 'Fault Code Clearing',
            self::MODULE_DIAGNOSTICS => 'Module Diagnostics',
            self::SENSOR_DIAGNOSTICS => 'Sensor Diagnostics',
            self::SENSOR_REPLACEMENT => 'Sensor Replacement',
            self::CALIBRATION => 'Calibration',
            self::CODING => 'Coding',
            self::ADAPTATION => 'Adaptation',
            self::RESET_SERVICE_INTERVAL => 'Reset Service Interval',
            self::RESET_ADAPTATIONS => 'Reset Adaptations',

            self::ADAS_DIAGNOSTICS => 'ADAS Diagnostics',
            self::ADAS_CALIBRATION => 'ADAS Calibration',
            self::CAMERA_CALIBRATION => 'Camera Calibration',
            self::RADAR_CALIBRATION => 'Radar Calibration',
            self::PARKING_SENSOR_REPLACEMENT => 'Parking Sensor Replacement',
            self::PARKING_SENSOR_DIAGNOSTICS => 'Parking Sensor Diagnostics',
            self::BLIND_SPOT_SENSOR_REPLACEMENT => 'Blind Spot Sensor Replacement',
            self::BLIND_SPOT_SYSTEM_DIAGNOSTICS => 'Blind Spot System Diagnostics',

            self::BODY_INSPECTION => 'Body Inspection',
            self::BODY_REPAIR => 'Body Repair',
            self::DENT_REPAIR => 'Dent Repair',
            self::PAINT_REPAIR => 'Paint Repair',
            self::PANEL_REPLACEMENT => 'Panel Replacement',
            self::BUMPER_REPAIR => 'Bumper Repair',
            self::BUMPER_REPLACEMENT => 'Bumper Replacement',
            self::BONNET_REPAIR => 'Bonnet Repair',
            self::BONNET_REPLACEMENT => 'Bonnet Replacement',
            self::DOOR_REPAIR => 'Door Repair',
            self::DOOR_REPLACEMENT => 'Door Replacement',
            self::WING_REPAIR => 'Wing Repair',
            self::WING_REPLACEMENT => 'Wing Replacement',
            self::BOOT_REPAIR => 'Boot Repair',
            self::BOOT_REPLACEMENT => 'Boot Replacement',
            self::MIRROR_REPAIR => 'Mirror Repair',
            self::MIRROR_REPLACEMENT => 'Mirror Replacement',
            self::FRAME_REPAIR => 'Frame Repair',
            self::CHASSIS_REPAIR => 'Chassis Repair',
            self::RUST_REPAIR => 'Rust Repair',
            self::UNDERBODY_REPAIR => 'Underbody Repair',

            self::INTERIOR_INSPECTION => 'Interior Inspection',
            self::INTERIOR_REPAIR => 'Interior Repair',
            self::SEAT_REPAIR => 'Seat Repair',
            self::SEAT_REPLACEMENT => 'Seat Replacement',
            self::CARPET_REPLACEMENT => 'Carpet Replacement',
            self::DASHBOARD_REPAIR => 'Dashboard Repair',
            self::INTERIOR_TRIM_REPAIR => 'Interior Trim Repair',
            self::SUNROOF_REPAIR => 'Sunroof Repair',
            self::WINDOW_REGULATOR_REPLACEMENT => 'Window Regulator Replacement',
            self::WINDOW_MOTOR_REPLACEMENT => 'Window Motor Replacement',
            self::CENTRAL_LOCKING_REPAIR => 'Central Locking Repair',

            self::AIRBAG_DIAGNOSTICS => 'Airbag Diagnostics',
            self::AIRBAG_REPLACEMENT => 'Airbag Replacement',
            self::SEATBELT_REPAIR => 'Seatbelt Repair',
            self::SEATBELT_REPLACEMENT => 'Seatbelt Replacement',
            self::SRS_DIAGNOSTICS => 'SRS Diagnostics',
            self::SRS_REPAIR => 'SRS Repair',

            self::EV_DIAGNOSTICS => 'EV Diagnostics',
            self::EV_BATTERY_DIAGNOSTICS => 'EV Battery Diagnostics',
            self::EV_BATTERY_SERVICE => 'EV Battery Service',
            self::EV_BATTERY_REPAIR => 'EV Battery Repair',
            self::EV_BATTERY_REPLACEMENT => 'EV Battery Replacement',
            self::EV_BATTERY_BALANCING => 'EV Battery Balancing',
            self::EV_CHARGING_SYSTEM_DIAGNOSTICS => 'EV Charging System Diagnostics',
            self::CHARGING_PORT_REPAIR => 'Charging Port Repair',
            self::ONBOARD_CHARGER_REPAIR => 'Onboard Charger Repair',
            self::ONBOARD_CHARGER_REPLACEMENT => 'Onboard Charger Replacement',
            self::DC_DC_CONVERTER_REPAIR => 'DC-DC Converter Repair',
            self::DC_DC_CONVERTER_REPLACEMENT => 'DC-DC Converter Replacement',
            self::INVERTER_REPAIR => 'Inverter Repair',
            self::INVERTER_REPLACEMENT => 'Inverter Replacement',
            self::HYBRID_SYSTEM_DIAGNOSTICS => 'Hybrid System Diagnostics',
            self::HYBRID_BATTERY_SERVICE => 'Hybrid Battery Service',
            self::HIGH_VOLTAGE_SYSTEM_INSPECTION => 'High-Voltage System Inspection',

            self::VEHICLE_INSPECTION => 'Vehicle Inspection',
            self::SAFETY_INSPECTION => 'Safety Inspection',
            self::PRE_PURCHASE_INSPECTION => 'Pre-Purchase Inspection',
            self::PRE_TRIP_INSPECTION => 'Pre-Trip Inspection',
            self::ROADWORTHINESS_INSPECTION => 'Roadworthiness Inspection',
            self::EMISSIONS_TEST => 'Emissions Test',
            self::VEHICLE_CERTIFICATION_INSPECTION => 'Vehicle Certification Inspection',
            self::POST_REPAIR_INSPECTION => 'Post-Repair Inspection',
            self::QUALITY_CONTROL_INSPECTION => 'Quality Control Inspection',

            self::VEHICLE_CLEANING => 'Vehicle Cleaning',
            self::INTERIOR_CLEANING => 'Interior Cleaning',
            self::EXTERIOR_CLEANING => 'Exterior Cleaning',
            self::ENGINE_BAY_CLEANING => 'Engine Bay Cleaning',
            self::CARPET_CLEANING => 'Carpet Cleaning',
            self::UPHOLSTERY_CLEANING => 'Upholstery Cleaning',
            self::PAINT_CORRECTION => 'Paint Correction',
            self::PAINT_POLISHING => 'Paint Polishing',
            self::PAINT_PROTECTION => 'Paint Protection',
            self::CERAMIC_COATING => 'Ceramic Coating',
            self::HEADLIGHT_POLISHING => 'Headlight Polishing',

            self::VEHICLE_RECOVERY => 'Vehicle Recovery',
            self::ROADSIDE_ASSISTANCE => 'Roadside Assistance',
            self::TOWING => 'Towing',
            self::DIAGNOSTIC_INSPECTION => 'Diagnostic Inspection',
            self::GENERAL_REPAIR => 'General Repair',
            self::GENERAL_SERVICE => 'General Service',
            self::OTHER => 'Other',
        };
    }
}
